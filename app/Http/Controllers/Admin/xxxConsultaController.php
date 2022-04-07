<?php

namespace App\Http\Controllers;


//[REQUEST]
use Illuminate\Http\Request;
use App\Http\Requests\Consulta\ConsultarDonante;



//[FACADES]
use Illuminate\Support\Facades\DB;



class ConsultaController extends Controller
{

    public function VerConsulta(Request $r)
    {
        return view('consulta/Consulta');
    }


    public function ConsultarDonanteEnHuav(Request $r)
    {
        
        $consulta = DB::connection('edelphyn')
            ->select("
                SELECT
                person.COD_CIVILID,
                person.DES_NAME,
                person.DES_SURNAME,
                person.COD_ACCEPTED,
                
                IF(person.COD_ACCEPTED = 'T' OR person.COD_ACCEPTED = 'P' OR person.COD_ACCEPTED = '@','',
                    (
                        SELECT
                        DATE_FORMAT( max(donation.DAT_DONATION),'%d/%m/%Y')
                        FROM donation
                        WHERE donation.ID_PERSON = person.ID_PERSON
                    )
                ) AS DAT_DONATION,
                
                
                IF(person.COD_ACCEPTED = 'T' OR person.COD_ACCEPTED = 'P' OR person.COD_ACCEPTED = '@','',
                    (
                        SELECT
                        donation_test.DES_RESULT
                        FROM donation_test, donation
                        WHERE donation_test.id_test = '12' 
                        AND donation.ID_PERSON = person.ID_PERSON
                        AND donation_test.ID_DONATION = donation.ID_DONATION
                        ORDER BY donation.DAT_DONATION DESC
                        LIMIT 1
                    )
                ) AS DES_RESULT_GRUPO_SANGUINEO,
                
                
                
                IF(person.COD_ACCEPTED = 'T' OR person.COD_ACCEPTED = 'P' OR person.COD_ACCEPTED = '@','',
                    (
                        SELECT
                        donation_test.DES_RESULT
                        FROM donation_test, donation
                        WHERE donation_test.id_test = '22' 
                        AND donation.ID_PERSON = person.ID_PERSON
                        AND donation_test.ID_DONATION = donation.ID_DONATION
                        ORDER BY donation.DAT_DONATION DESC
                        LIMIT 1
                    )
                ) AS DES_RESULT_FACTOR_RH,
                
                
                IF(person.COD_ACCEPTED = 'A' OR person.COD_ACCEPTED = 'P' OR person.COD_ACCEPTED = '@','',
                DATE_FORMAT( person.DAT_DEFERRED,'%d/%m/%Y')
                ) AS DAT_DEFERRED,

                (
                    SELECT
                    COUNT(*)
                    FROM OFFER
                    WHERE offer.ID_PERSON = person.ID_PERSON
                    AND offer.COD_DONATION <> ''
                    AND offer.COD_DONATION IS NOT NULL
                )AS CONTADOR_OFRECIMIENTOS_ACEPTADOS,               
                
                (
                    SELECT
                    donation.COD_VALIDATED
                    FROM
                    DONATION
                    WHERE donation.ID_PERSON = person.ID_PERSON
                    ORDER BY donation.DAT_DONATION DESC
                    LIMIT 1
                ) AS ESTADO_VALIDACION_ULTIMA_DONACION
                
                FROM person
                WHERE person.COD_CIVILID = '".$r->identificacion."'
		AND person.LOG_DONOR = 'Y'
                LIMIT 1
            ");

        if( count($consulta) == 0 ) return Response()->json([], 204);

        $calendario = array();

        if($consulta[0]->COD_ACCEPTED == 'A'){
            $calendario = $this->ConstruirCalendarioDonante($r->identificacion);
        }

        if( count($consulta) > 0 ) return Response()->json( array(
            'consulta' => $consulta[0],
            'calendario' => $calendario
        ) , 202);

    }

    public function ConsultarDonanteEnSihevi(Request $r)
    {
        
        $headers = array(
            'Content-Type:application/json',
            'Authorization: Basic YnNoZW1vY2VudHJvdmFsbGVkdXBhcjpwYXNzMjczKg=='
        );

        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, "https://apps.ins.gov.co/SiheviAPI/Donacion/ConsultaDonante?doc=".$r->identificacion."&tipo_doc=".$r->tipo_documento);
        curl_setopt($c, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, true);
        $respuesta = json_decode(curl_exec($c));
        $info = curl_getinfo($c);
        curl_close($c);

        if($info['http_code'] != 200) return Response()->json([],503);

        $hisDo = $respuesta->HistoricoDonaciones;

        if( count($hisDo) < 1 ) return Response()->json([], 204);

        $ultimaDonacion = $this->ObtenerUltimaDonacion($hisDo);

        return Response()->json( $ultimaDonacion, 202 );

    }


    //Función privada que convierte una fecha dd/mm/yyyy -> yyyy-mm-dd
    private function ConvertirFormatoFecha($fecha)
    {
        return substr($fecha, 6).'-'.substr($fecha, 3, 2).'-'.substr($fecha, 0, 2);
    }

    //Función privada que extrae la ultima donación por fecha
    private function ObtenerUltimaDonacion($historicoDonaciones)
    {
        $ultimaDonacion = array();        
        $fechaUltimaDonacion = '1800-01-01';

        foreach($historicoDonaciones as $donacion)
        {
            
            $tiempoUltimaDonacion = strtotime($fechaUltimaDonacion);

            if( strtotime( $this->ConvertirFormatoFecha($donacion->FECHA_DONACION) ) > $tiempoUltimaDonacion )
            {
                $fechaUltimaDonacion = $this->ConvertirFormatoFecha($donacion->FECHA_DONACION);
            }

        }

        foreach($historicoDonaciones as $donacion)
        {
            
            if( $this->ConvertirFormatoFecha($donacion->FECHA_DONACION) == $fechaUltimaDonacion )
            {
                $ultimaDonacion = $donacion;
            }

        }

        return $ultimaDonacion;

    }

    //Función privada que construye el calendario del donante
    private function ConstruirCalendarioDonante($identificacion){
        
        $idperson = DB::connection('edelphyn')
            ->select("
                SELECT
                person.ID_PERSON
                FROM
                person
                WHERE
                person.COD_CIVILID = '".$identificacion."'
            ")[0]->ID_PERSON;
        
        return $this->ConsultarCalendarioDonante($idperson);
    }

    //Función privada que consulta el calendario del donante
    public function ConsultarCalendarioDonante($idperson)
    {
        
        $resultados = DB::connection('edelphyn')
            ->select("
                SELECT
                person.DES_NAME AS NOMBRE_DONANTE,
                person.DES_SURNAME AS APELLIDO_DONANTE,
                person.COD_CIVILID AS IDENTIFICACION_DONANTE,
                person.COD_ACCEPTED AS ESTADO_DONANTE,
                IF(
                    person.COD_ACCEPTED = 'A', 'ACEPTADO',
                    IF(
                        person.COD_ACCEPTED = 'P', 'DIFERIDO PERMANENTEMENTE',
                        IF(
                            person.COD_ACCEPTED = 'T', 'DIFERIDO TEMPORALMENTE', 'INDETERMINADO'
                        )
                    )
                ) AS ESTADO_DONANTE_TEXTO,


                IF(
                    (
                        SELECT
                        COUNT(*)
                        FROM
                        DONATION
                        WHERE
                        donation.ID_PERSON = person.ID_PERSON
                    ) = 0, '-',
                    
                    (
                        SELECT
                        DATE_FORMAT( donation.DAT_DONATION, '%d/%m/%Y' )
                        FROM DONATION
                        WHERE
		                donation.ID_PERSON = person.ID_PERSON
                        ORDER BY donation.DAT_DONATION DESC
                        LIMIT 1
                    )
                    
                ) AS ULTIMA_DONACION_FECHA,


		IF(
                    (
                        SELECT
                        COUNT(*)
                        FROM
                        DONATION
                        WHERE
                        donation.ID_PERSON = person.ID_PERSON
                    ) = 0, '-',
                    
                    (
                        SELECT
                        COD_DONATION
                        FROM DONATION
                        WHERE
		                donation.ID_PERSON = person.ID_PERSON
                        ORDER BY donation.DAT_DONATION DESC
                        LIMIT 1
                    )
                    
                ) AS ULTIMA_DONACION_CODIGO,



                IF(
                    (
                        SELECT
                        COUNT(*)
                        FROM
                        DONATION
                        WHERE
                        donation.ID_PERSON = person.ID_PERSON
                    ) = 0, '-',
                    
                    IF(
                        (
                            SELECT
                            donation.COD_DONATIONKIND
                            FROM DONATION
                          WHERE
                            donation.ID_PERSON = person.ID_PERSON
                          ORDER BY donation.DAT_DONATION DESC
                          LIMIT 1
                        ) = 'D', 'SANGRE TOTAL',
                        
                        IF(
                            (
                                SELECT
                                donation.COD_DONATIONKIND
                                FROM DONATION
                              WHERE
                                donation.ID_PERSON = person.ID_PERSON
                              ORDER BY donation.DAT_DONATION DESC
                              LIMIT 1
                            ) = 'A'
                            
                            AND
                            
                            (
                                SELECT
                                donation.ID_BAGTYPE
                                FROM DONATION
                              WHERE
                                donation.ID_PERSON = person.ID_PERSON
                              ORDER BY donation.DAT_DONATION DESC
                              LIMIT 1
                            ) = '15', 'HEMAFERESIS',
                            
                            
                            IF(
                            
                                (
                                    SELECT
                                        donation.COD_DONATIONKIND
                                        FROM DONATION
                                      WHERE
                                        donation.ID_PERSON = person.ID_PERSON
                                      ORDER BY donation.DAT_DONATION DESC
                                      LIMIT 1
                                    ) = 'A'
                                
                                    AND
                                    
                                    (
                                        SELECT
                                        donation.ID_BAGTYPE
                                        FROM DONATION
                                      WHERE
                                        donation.ID_PERSON = person.ID_PERSON
                                      ORDER BY donation.DAT_DONATION DESC
                                      LIMIT 1
                                    ) = '16', 'PLAQUETAS', 


                                    IF(
							
                                        (
                                            SELECT
                                            donation.COD_DONATIONKIND
                                            FROM DONATION
                                            WHERE
                                            donation.ID_PERSON = person.ID_PERSON
                                            ORDER BY donation.DAT_DONATION DESC
                                            LIMIT 1
                                        ) = 'A'
                                    
                                        AND
                                        
                                        (
                                            SELECT
                                            donation.ID_BAGTYPE
                                            FROM DONATION
                                            WHERE
                                            donation.ID_PERSON = person.ID_PERSON
                                            ORDER BY donation.DAT_DONATION DESC
                                            LIMIT 1
                                        ) = '1', 'PLAQUETAS','INDETERMINADO' 
                                        
                                    )

                            
                            )
                            
                            
                            
                        )
                        
                        
                    )
                    
                ) AS ULTIMA_DONACION_TIPO,


                IF(
                    (
                        SELECT
                        COUNT(*)
                        FROM
                        DONATION
                        WHERE
                        donation.ID_PERSON = person.ID_PERSON
                    ) = 0, '-',
                    
                    (
                        SELECT
                      collectsite.DES_COLLECTSITE
                      FROM offer, donation, COLLECTSITE
                      WHERE
                      offer.COD_DONATION = donation.COD_DONATION
                      AND offer.ID_COLLECTSITE = collectsite.ID_COLLECTSITE
                        AND donation.ID_PERSON = person.ID_PERSON
                      ORDER BY donation.DAT_DONATION DESC
                      LIMIT 1
                    )
                    
                ) AS ULTIMA_DONACION_SITIO,


                IF(
                    (
                        SELECT
                        COUNT(*)
                        FROM
                        DONATION
                        WHERE
                        donation.ID_PERSON = person.ID_PERSON
                    ) = 0, '-',
                    
                    IF(
                        (
                            SELECT
                            donation.COD_VALIDATED
                            FROM DONATION
                          WHERE
                            donation.ID_PERSON = person.ID_PERSON
                          ORDER BY donation.DAT_DONATION DESC
                          LIMIT 1
                        ) = 'N','FALTA VALIDACION',
                        
                        IF(
                            (
                                SELECT
                                donation.COD_VALIDATED
                                FROM DONATION
                              WHERE
                                donation.ID_PERSON = person.ID_PERSON
                              ORDER BY donation.DAT_DONATION DESC
                              LIMIT 1
                            ) = 'A','ACEPTADA',
                            
                            
                            IF(
                                (
                                    SELECT
                                    donation.COD_VALIDATED
                                    FROM DONATION
                                  WHERE
                                    donation.ID_PERSON = person.ID_PERSON
                                  ORDER BY donation.DAT_DONATION DESC
                                  LIMIT 1
                                ) = 'R','RECHAZADA','INDETERMINADA'
                            )
                            
                            
                        )
                        
                    )
                    
                ) AS ULTIMA_DONACION_ESTADO,


                DATE_FORMAT( person.DAT_DEFERRED, '%d/%m/%Y' ) AS FECHA_FIN_DIFERIMIENTO_TEMPORAL,


                IF(
                    person.COD_ACCEPTED <> 'T','',
                    
                    (   
                        SELECT
                        deferredreason.DES_DEFERREDREASON
                        FROM deferredreason, offer
                        WHERE offer.ID_PERSON = person.ID_PERSON
                        AND offer.ID_DEFERREDREASON = deferredreason.ID_DEFERREDREASON
                        ORDER BY offer.DAT_OFFER desc
                        LIMIT 1
                    )
                
                ) AS RAZON_DIFERIMIENTO_TEMPORAL,



                IF(
                    person.COD_ACCEPTED <> 'T', 0 ,
                    
                    (
                        SELECT
                        deferredreason.NUM_DEFERREDDAYS
                        FROM deferredreason, offer
                        WHERE offer.ID_PERSON = person.ID_PERSON
                        AND offer.ID_DEFERREDREASON = deferredreason.ID_DEFERREDREASON
                        ORDER BY offer.DAT_OFFER desc
                        LIMIT 1
                    )
                
                ) AS DIAS_RELACIONADOS_DIFERIMIENTO_TEMPORAL,



                IF
                (
                    person.COD_ACCEPTED <> 'T', 0 ,  
                    IF(
                            (
                                DATEDIFF( person.DAT_DEFERRED, CURDATE() )  
                            ) <= 0, 0,
                            DATEDIFF( person.DAT_DEFERRED, CURDATE() )
                    )
                ) AS DIAS_PENDIENTES_DIFERIMIENTO_TEMPORAL



                FROM person
                WHERE person.ID_PERSON = '".$idperson."'
            ");

        
        return $this->CompletarInformacionCalendario($resultados[0], $idperson);

    }


    private function CompletarInformacionCalendario($datos, $id)
    {

        if($datos->ESTADO_DONANTE == 'P'){
            $datos->PROXIMA_SANGRE_TOTAL = '-';
            $datos->PROXIMA_HEMAFERESIS = '-';
            $datos->PROXIMA_PLAQUETAS = '-';
        }
        
        if($datos->ESTADO_DONANTE == '@' && $datos->ULTIMA_DONACION_FECHA == '-'){
            $datos->PROXIMA_SANGRE_TOTAL = 'DISPONIBLE';
            $datos->PROXIMA_HEMAFERESIS = '-';
            $datos->PROXIMA_PLAQUETAS = '-';
        }

        if($datos->ESTADO_DONANTE == '@' && $datos->ULTIMA_DONACION_ESTADO == 'FALTA VALIDACION'){
            $datos->PROXIMA_SANGRE_TOTAL = '-';
            $datos->PROXIMA_HEMAFERESIS = '-';
            $datos->PROXIMA_PLAQUETAS = '-';
        }

        if($datos->ESTADO_DONANTE == 'T' && $datos->DIAS_PENDIENTES_DIFERIMIENTO_TEMPORAL > 0){
            $datos->PROXIMA_SANGRE_TOTAL = '-';
            $datos->PROXIMA_HEMAFERESIS = '-';
            $datos->PROXIMA_PLAQUETAS = '-';
        }

        if($datos->ESTADO_DONANTE == 'T' && $datos->ULTIMA_DONACION_FECHA == '-' && $datos->DIAS_PENDIENTES_DIFERIMIENTO_TEMPORAL == 0){
            $datos->PROXIMA_SANGRE_TOTAL = 'DISPONIBLE';
            $datos->PROXIMA_HEMAFERESIS = '-';
            $datos->PROXIMA_PLAQUETAS = '-';
        }


        if( ($datos->ESTADO_DONANTE == 'A' && $datos->ULTIMA_DONACION_FECHA != '-' && $datos->ULTIMA_DONACION_TIPO == 'SANGRE TOTAL')
            ||
            ($datos->ESTADO_DONANTE == 'T' && $datos->DIAS_PENDIENTES_DIFERIMIENTO_TEMPORAL == 0 && $datos->ULTIMA_DONACION_FECHA != '-' && $datos->ULTIMA_DONACION_TIPO == 'SANGRE TOTAL')
        ){

            $diasEsperaSTyHE = DB::connection('edelphyn')
                ->select("
                    SELECT

                    IF(
                            ( person.COD_GENDER ) = 'F',
                            
                            (
                                SELECT
                                DATEDIFF( DATE_ADD(donation.DAT_DONATION, INTERVAL 4 MONTH), CURDATE() )
                                FROM DONATION
                                WHERE donation.ID_PERSON = person.ID_PERSON
                                AND donation.COD_DONATIONKIND = 'D'
                                ORDER BY donation.DAT_DONATION DESC
                                LIMIT 1
                            ), 
                            
                            
                            IF(
                                ( person.COD_GENDER ) = 'M',
                                
                                (
                                    SELECT
                                    DATEDIFF( DATE_ADD(donation.DAT_DONATION, INTERVAL 3 MONTH), CURDATE() )
                                    FROM DONATION
                                    WHERE donation.ID_PERSON = person.ID_PERSON
                                    AND donation.COD_DONATIONKIND = 'D'
                                    ORDER BY donation.DAT_DONATION DESC
                                    LIMIT 1
                                ),
    
                                '-'
                            )
                                               
                            
                        ) AS DIAS_DESPUES_SANGRE_TOTAL
                    
                    FROM person
                    WHERE person.ID_PERSON = '".$id."'
                ")[0]->DIAS_DESPUES_SANGRE_TOTAL;


            if($diasEsperaSTyHE <= 0){
                $datos->PROXIMA_SANGRE_TOTAL = 'DISPONIBLE';
                $datos->PROXIMA_HEMAFERESIS = 'DISPONIBLE';
            }

            if($diasEsperaSTyHE > 0){
                $datos->PROXIMA_SANGRE_TOTAL = 'En '.$diasEsperaSTyHE.' Días';
                $datos->PROXIMA_HEMAFERESIS = 'En '.$diasEsperaSTyHE.' Días';
            }


            $diasEsperaPQ = DB::connection('edelphyn')
                ->select("
                    SELECT

                    (
                        SELECT
                        DATEDIFF( DATE_ADD(donation.DAT_DONATION, INTERVAL 1 MONTH), CURDATE() )
                        FROM DONATION
                        WHERE donation.ID_PERSON = person.ID_PERSON
                        ORDER BY donation.DAT_DONATION DESC
                        LIMIT 1   
                        
                    ) AS PROXIMA_PLAQUETAS
                    
                    FROM person
                    WHERE person.ID_PERSON = '".$id."'
                ")[0]->PROXIMA_PLAQUETAS;


            if($diasEsperaPQ <= 0){
                $datos->PROXIMA_PLAQUETAS = 'DISPONIBLE';
            }

            if($diasEsperaPQ > 0){
                $datos->PROXIMA_PLAQUETAS = 'En '.$diasEsperaPQ.' Días';
            }
            

        }



        if( ($datos->ESTADO_DONANTE == 'A' && $datos->ULTIMA_DONACION_FECHA != '-' && $datos->ULTIMA_DONACION_TIPO == 'HEMAFERESIS')
            ||
            ($datos->ESTADO_DONANTE == 'T' && $datos->DIAS_PENDIENTES_DIFERIMIENTO_TEMPORAL == 0 && $datos->ULTIMA_DONACION_FECHA != '-' && $datos->ULTIMA_DONACION_TIPO == 'HEMAFERESIS')
        ){

            $diasEsperaSTyHE = DB::connection('edelphyn')
                ->select("
                    SELECT

                    (
                        SELECT
                        DATEDIFF( DATE_ADD(donation.DAT_DONATION, INTERVAL 4 MONTH), CURDATE() )
                        FROM DONATION
                        WHERE donation.ID_PERSON = person.ID_PERSON
                        ORDER BY donation.DAT_DONATION DESC
                        LIMIT 1   
                        
                    ) AS DIAS_DESPUES_HEMAFERESIS
                    
                    FROM person
                    WHERE person.ID_PERSON = '".$id."'
                ")[0]->DIAS_DESPUES_HEMAFERESIS;


            if($diasEsperaSTyHE <= 0){
                $datos->PROXIMA_SANGRE_TOTAL = 'DISPONIBLE';
                $datos->PROXIMA_HEMAFERESIS = 'DISPONIBLE';
            }

            if($diasEsperaSTyHE > 0){
                $datos->PROXIMA_SANGRE_TOTAL = 'En '.$diasEsperaSTyHE.' Días';
                $datos->PROXIMA_HEMAFERESIS = 'En '.$diasEsperaSTyHE.' Días';
            }


            $diasEsperaPQ = DB::connection('edelphyn')
                ->select("
                    SELECT

                    (
                        SELECT
                        DATEDIFF( DATE_ADD(donation.DAT_DONATION, INTERVAL 1 MONTH), CURDATE() )
                        FROM DONATION
                        WHERE donation.ID_PERSON = person.ID_PERSON
                        ORDER BY donation.DAT_DONATION DESC
                        LIMIT 1   
                        
                    ) AS PROXIMA_PLAQUETAS
                    
                    FROM person
                    WHERE person.ID_PERSON = '".$id."'
                ")[0]->PROXIMA_PLAQUETAS;


            if($diasEsperaPQ <= 0){
                $datos->PROXIMA_PLAQUETAS = 'DISPONIBLE';
            }

            if($diasEsperaPQ > 0){
                $datos->PROXIMA_PLAQUETAS = 'EN '.$diasEsperaPQ.' DÍAS';
            }
            

        }



        if( ($datos->ESTADO_DONANTE == 'A' && $datos->ULTIMA_DONACION_FECHA != '-' && $datos->ULTIMA_DONACION_TIPO == 'PLAQUETAS')
            ||
            ($datos->ESTADO_DONANTE == 'T' && $datos->DIAS_PENDIENTES_DIFERIMIENTO_TEMPORAL == 0 && $datos->ULTIMA_DONACION_FECHA != '-' && $datos->ULTIMA_DONACION_TIPO == 'PLAQUETAS')
        ){


            $diasEsperaPQ = DB::connection('edelphyn')
                ->select("
                    SELECT

                    (
                        SELECT
                        DATEDIFF( DATE_ADD(donation.DAT_DONATION, INTERVAL 1 MONTH), CURDATE() )
                        FROM DONATION
                        WHERE donation.ID_PERSON = person.ID_PERSON
                        ORDER BY donation.DAT_DONATION DESC
                        LIMIT 1   
                        
                    ) AS PROXIMA_PLAQUETAS
                    
                    FROM person
                    WHERE person.ID_PERSON = '".$id."'
                ")[0]->PROXIMA_PLAQUETAS;


            if($diasEsperaPQ <= 0){
                $datos->PROXIMA_PLAQUETAS = 'DISPONIBLE';
            }

            if($diasEsperaPQ > 0){
                $datos->PROXIMA_PLAQUETAS = 'EN '.$diasEsperaPQ.' DÍAS';
            }


            $tipoUltimaDonacionSangre = DB::connection('edelphyn')
                ->select("
                    SELECT

                    IF(
                        (
                            SELECT
                            donation.ID_BAGTYPE
                            FROM DONATION
                            WHERE
                            donation.ID_BAGTYPE = 15 OR donation.ID_BAGTYPE = 17 OR donation.ID_BAGTYPE = 9 OR donation.ID_BAGTYPE = 3
                            AND donation.ID_PERSON = '".$id."'
                            ORDER BY donation.DAT_DONATION DESC
                            LIMIT 1
                        ) = 15,'HEMAFERESIS',
                        
                        IF(
                            (
                                SELECT
                                donation.ID_BAGTYPE
                                FROM DONATION
                                WHERE
                                donation.ID_BAGTYPE = 15 OR donation.ID_BAGTYPE = 17 OR donation.ID_BAGTYPE = 9 OR donation.ID_BAGTYPE = 3
                                AND donation.ID_PERSON = '".$id."'
                                ORDER BY donation.DAT_DONATION DESC
                                LIMIT 1
                            ) = 17,'SANGRE TOTAL', 
                            
                            IF(
                                (
                                    SELECT
                                    donation.ID_BAGTYPE
                                    FROM DONATION
                                    WHERE
                                    donation.ID_BAGTYPE = 15 OR donation.ID_BAGTYPE = 17 OR donation.ID_BAGTYPE = 9 OR donation.ID_BAGTYPE = 3
                                    AND donation.ID_PERSON = '".$id."'
                                    ORDER BY donation.DAT_DONATION DESC
                                    LIMIT 1
                                ) = 9,'SANGRE TOTAL', 
                            
                            
                                IF(
                                    (
                                        SELECT
                                        donation.ID_BAGTYPE
                                        FROM DONATION
                                        WHERE
                                        donation.ID_BAGTYPE = 15 OR donation.ID_BAGTYPE = 17 OR donation.ID_BAGTYPE = 9 OR donation.ID_BAGTYPE = 3
                                        AND donation.ID_PERSON = '".$id."'
                                        ORDER BY donation.DAT_DONATION DESC
                                        LIMIT 1
                                    ) = 3,'SANGRE TOTAL', 'NO APLICA' 			
                                
                                
                                
                                )
                            
                            )
                            
                            
                        )
                    ) AS TIPO_ULTIMA_DONACION_SANGRE
                ")[0]->TIPO_ULTIMA_DONACION_SANGRE;


            if($tipoUltimaDonacionSangre == 'HEMAFERESIS'){

                $diasEsperaSTyHE = DB::connection('edelphyn')
                    ->select("
                        SELECT

                        (
                            SELECT
                            DATEDIFF( DATE_ADD(donation.DAT_DONATION, INTERVAL 4 MONTH), CURDATE() )
                            FROM DONATION
                            WHERE donation.ID_PERSON = person.ID_PERSON
                            AND donation.ID_BAGTYPE = '15'
                            ORDER BY donation.DAT_DONATION DESC
                            LIMIT 1   
                            
                        ) AS DIAS_DESPUES_HEMAFERESIS
                        
                        FROM person
                        WHERE person.ID_PERSON = '".$id."'
                    ")[0]->DIAS_DESPUES_HEMAFERESIS;

                if($diasEsperaSTyHE <= 0){
                    $datos->PROXIMA_SANGRE_TOTAL = $datos->PROXIMA_PLAQUETAS;
                    $datos->PROXIMA_HEMAFERESIS = $datos->PROXIMA_PLAQUETAS;
                }

                if($diasEsperaSTyHE > 0){

                    if($diasEsperaSTyHE < $diasEsperaPQ){
                        $datos->PROXIMA_SANGRE_TOTAL = $datos->PROXIMA_PLAQUETAS;
                        $datos->PROXIMA_HEMAFERESIS = $datos->PROXIMA_PLAQUETAS;
                    }

                    if($diasEsperaSTyHE > $diasEsperaPQ){
                        $datos->PROXIMA_SANGRE_TOTAL = 'En '.$diasEsperaSTyHE.' Días';
                        $datos->PROXIMA_HEMAFERESIS = 'En '.$diasEsperaSTyHE.' Días';
                    }

                }

            }



            if($tipoUltimaDonacionSangre == 'SANGRE TOTAL'){
                
                $diasEsperaSTyHE = DB::connection('edelphyn')
                    ->select("
                        SELECT

                        IF(
                            ( person.COD_GENDER ) = 'F',
                            
                            (
                                SELECT
                                DATEDIFF( DATE_ADD(donation.DAT_DONATION, INTERVAL 4 MONTH), CURDATE() )
                                FROM DONATION
                                WHERE donation.ID_PERSON = person.ID_PERSON
                                AND donation.COD_DONATIONKIND = 'D'
                                ORDER BY donation.DAT_DONATION DESC
                                LIMIT 1
                            ), 
                            
                            
                            IF(
                                ( person.COD_GENDER ) = 'M',
                                
                                (
                                    SELECT
                                    DATEDIFF( DATE_ADD(donation.DAT_DONATION, INTERVAL 3 MONTH), CURDATE() )
                                    FROM DONATION
                                    WHERE donation.ID_PERSON = person.ID_PERSON
                                    AND donation.COD_DONATIONKIND = 'D'
                                    ORDER BY donation.DAT_DONATION DESC
                                    LIMIT 1
                                ),
    
                                '-'
                            )
                                               
                            
                        ) AS DIAS_DESPUES_SANGRE_TOTAL
                        
                        FROM person
                        WHERE person.ID_PERSON = '".$id."'
                    ")[0]->DIAS_DESPUES_SANGRE_TOTAL;

                if($diasEsperaSTyHE <= 0){
                    $datos->PROXIMA_SANGRE_TOTAL = $datos->PROXIMA_PLAQUETAS;
                    $datos->PROXIMA_HEMAFERESIS = $datos->PROXIMA_PLAQUETAS;
                }

                if($diasEsperaSTyHE > 0){

                    if($diasEsperaSTyHE < $diasEsperaPQ){
                        $datos->PROXIMA_SANGRE_TOTAL = $datos->PROXIMA_PLAQUETAS;
                        $datos->PROXIMA_HEMAFERESIS = $datos->PROXIMA_PLAQUETAS;
                    }

                    if($diasEsperaSTyHE > $diasEsperaPQ){
                        $datos->PROXIMA_SANGRE_TOTAL = 'En '.$diasEsperaSTyHE.' Días';
                        $datos->PROXIMA_HEMAFERESIS = 'En '.$diasEsperaSTyHE.' Días';
                    }

                }

                

            }






        }
        

        return $datos;


    }



}

