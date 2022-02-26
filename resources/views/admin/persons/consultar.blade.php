
@extends('adminlte::page')

@section('title','Dashboar')

@section('content_header')
    <h1>List of donors</h1>
@stop

@section('content')


    <div class="container">

        

        <div class="card">
            <div class="card-header text-center">
                CONSULTA EXTRAMURAL
            </div>
            <div class="card-body" v-if=" permisos.find( e => e === 36 ) || permisos.find( e => e === 37 ) ">               
                

		<div class="form-group">
                    <label><i class="text-danger">*</i> Tipo de documento</label>
                    <select v-model="tipo_documento" class="form-control">
                        <option value="CC">CC - CEDULA DE CIUDADANÍA</option>
                        <option value="CE">CE - CEDULA DE EXTRANJERÍA</option>
                        <option value="PA">PA - PASAPORTE</option>
                        <option value="NUIP">NUIP - NÚMERO ÚNICO DE IDENTIFICACIÓN PERSONAL</option>
                        <option value="PE">PE - PERMISO ESPECIAL DE PERMANENCIA</option>
                    </select>
                </div>


                <div class="form-group">
                    <label>Identificación</label>
                    <input
			@keydown.tab.prevent="GestionarLectura($event.target.value)" 
			v-model="identificacion" type="text" class="form-control">
                </div>

		
                <section class="row">
                    <div class="col-6">
                        <a class="btn btn-outline-success" href="ConsultarDonanteEnHuav()">Consult Donors</a>
                        <!--<button v-on:click="ConsultarDonanteEnHuav()" class="btn btn-block btn-primary"><i class="fa fa-h-square"></i>Bancos</button>-->
                    </div>
                    <div class="col-6">
                        <button v-on:click="ConsultarDonanteEnSihevi()" class="btn btn-block btn-danger"><i class="fa fa-globe"></i> SIHEVI</button>
                    </div>
                </section>                

            </div>
        </div>  

        
        <div class="modal fade" id="ModalCalendario" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">HUAV DICE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        
                        <div class="alert alert-success" role="alert">
                            <p>El donante <strong>@{{ modal.nombre }}</strong> esta en <strong>ESTADO ACEPTADO</strong>, su última donación fue de <strong>@{{ modal.ultima_donacion_tipo }}</strong> el día <strong>@{{ modal.ultima_donacion_fecha }}</strong>.</p>
                            <p>Tipo sanguineo: <strong>@{{ modal.sangre }}</strong></p>
                        </div>

		        <p class="text-center text-success mb-3">.::Próximas Donaciones::.</p>

                        <table class="table table-sm table-striped table-hover table-bordered">
                            <thead>
                                <tr>
                                    <th>TIPO</th>
                                    <th>DISPONIBLE</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>SANGRE TOTAL</td>
                                    <td>@{{ modal.sangre_total }}</td>
                                </tr>
                                <tr>
                                    <td>HEMAFERESIS</td>
                                    <td>@{{ modal.hemaferesis }}</td>
                                </tr>
                                <tr>
                                    <td>PLAQUETAS</td>
                                    <td>@{{ modal.plaquetas }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>      


    </div>

@endsection


@section('funcionalidad')

    <script>

        var app = new Vue({
            el: '#app',
            data:
            {
                cargando: true,
                permisos:[],
                identificacion: '',
		tipo_documento:'CC',
                modal:{
                    nombre:'',
                    sangre:'',
                    ultima_donacion_fecha:'',
                    ultima_donacion_tipo:'',
                    sangre_total: '',
                    hemaferesis:'',
                    plaquetas: ''
                },


		bandera: 0,
                auxiliar_identificacion:''


            },
            methods:
            {                

                ConsultarPermisos: async function()
                {

                    try
                    {

                        let res = await axios.get(
                            '{{ asset("permisos/usuario") }}',
                            {
                                headers:{
                                    'X-Requested-With' : 'XMLHttpRequest',
                                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                                }
                            }
                        );

                        if(res.status === 202) this.permisos = res.data;

                    }
                    catch(e)
                    {

                    }

                },


                ConsultarDonanteEnHuav: async function(){

                    this.cargando = true;

                    try{

                        let res = await axios.get(
                            '{{ asset("consulta/consulta-en-huav?identificacion=") }}'+this.identificacion+'&tipo_documento='+this.tipo_documento,
                            {
                                headers:{
                                    'X-Requested-With' : 'XMLHttpRequest',
                                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                                }
                            }
                        );

                        if(res.status === 204) swal('HUAV DICE:','El donante no existe en la base de datos.','success');

                        if(res.data.consulta.COD_ACCEPTED === 'P'){
                            swal('HUAV DICE:','El donante '+res.data.consulta.DES_NAME+' '+res.data.consulta.DES_SURNAME+' se encuentra DIFERIDO PERMANENTEMENTE.','error');
                        }

                        if(res.data.consulta.COD_ACCEPTED === 'T'){
                            swal('HUAV DICE:','El donante '+res.data.consulta.DES_NAME+' '+res.data.consulta.DES_SURNAME+' se encuentra DIFERIDO TEMPORALMENTE. Cabe agregar, que este diferimiento termina el día '+res.data.consulta.DAT_DEFERRED,'warning');
                        }

                        if(res.data.consulta.COD_ACCEPTED === '@'){
                            if(res.data.consulta.CONTADOR_OFRECIMIENTOS_ACEPTADOS === 0) swal('HUAV DICE:','El donante' + res.data.consulta.DES_NAME+' '+res.data.consulta.DES_SURNAME+' no tiene donaciones registradas','success');
                            if(res.data.consulta.CONTADOR_OFRECIMIENTOS_ACEPTADOS > 0) swal('HUAV DICE:','El donante se encuentra en ESTADO INDETERMINADO o tiene una DONACIÓN SIN VALIDAR. Para mayor información, comunicate con el área de sistemas.','info');
                        }


                        if(res.data.consulta.COD_ACCEPTED === 'A'){
                            this.modal.nombre = res.data.consulta.DES_NAME+' '+res.data.consulta.DES_SURNAME;
                            this.modal.ultima_donacion_tipo = res.data.calendario.ULTIMA_DONACION_TIPO;
                            this.modal.ultima_donacion_fecha = res.data.calendario.ULTIMA_DONACION_FECHA;
                            this.modal.sangre = res.data.consulta.DES_RESULT_GRUPO_SANGUINEO+' '+res.data.consulta.DES_RESULT_FACTOR_RH; 
                            this.modal.sangre_total = res.data.calendario.PROXIMA_SANGRE_TOTAL;
                            this.modal.hemaferesis = res.data.calendario.PROXIMA_HEMAFERESIS;
                            this.modal.plaquetas = res.data.calendario.PROXIMA_PLAQUETAS;
                            $('#ModalCalendario').modal('show');
                        }


                    }
                    catch(e){
                        if(e.response.status === 422) swal('Error.','La información contiene errores, verifique por favor.','error');
                    }
                    finally{
                        this.cargando = false;
                    }

                },


                ConsultarDonanteEnSihevi: async function(){

                    this.cargando = true;

                    try{

                        let res = await axios.get(
                            '{{ asset("consulta/consulta-en-sihevi?identificacion=") }}'+this.identificacion+'&tipo_documento='+this.tipo_documento,
                            {
                                headers:{
                                    'X-Requested-With' : 'XMLHttpRequest',
                                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                                }
                            }
                        );

                        if(res.status === 204) swal('SIHEVI DICE:','El donante no existe en la base de datos.','success');

                        if(res.status === 202){
                            if(res.data.TIPO_DONANTE === 'Aceptado'){
                                swal('SIHEVI DICE:','El donante '+res.data.PRIMER_NOMBRE+' '+res.data.PRIMER_APELLIDO+' está ACEPTADO, su última donación fue de '+res.data.TIPO_DONACION+' en el banco '+res.data.NOMBRE_BANCO+' el día '+res.data.FECHA_DONACION,'success');
                            }
                            if(res.data.TIPO_DONANTE === 'Diferido Temporal'){
                                swal('SIHEVI DICE:','El donante '+res.data.PRIMER_NOMBRE+' '+res.data.PRIMER_APELLIDO+' está DIFERIDO TEMPORALMENTE, su última donación fue en el banco '+res.data.NOMBRE_BANCO+' el día '+res.data.FECHA_DONACION,'warning');
                            }
                            if(res.data.TIPO_DONANTE === 'Diferido Permanente'){
                                swal('SIHEVI DICE:','El donante '+res.data.PRIMER_NOMBRE+' '+res.data.PRIMER_APELLIDO+' está DIFERIDO PERMANENTEMENTE, su última donación fue en el banco '+res.data.NOMBRE_BANCO+' el día '+res.data.FECHA_DONACION,'error');
                            }
                        }

                    }
                    catch(e){
                        if(e.response.status === 422) swal('Error.','La información contiene errores, verifique por favor.','error');
                        if(e.response.status === 503) swal('Error.','No hay conexión con el API SIHEVI.','error');
                    }
                    finally{
                        this.cargando = false;
                    }

                },


		GestionarLectura: function(informacion){

                    this.bandera = this.bandera + 1;

                    if(this.bandera === 1){
                        this.auxiliar_identificacion = informacion;
                    }

                    if(this.bandera === 7){
                        this.bandera = 0;
                        this.identificacion = '' + this.auxiliar_identificacion.replace(/^0+/, '');
                        return false;
                    }

                }


                

            },
            created: function()
            {
                this.cargando = false;
                this.ConsultarPermisos();
            }
        });

    </script>

@endsection
