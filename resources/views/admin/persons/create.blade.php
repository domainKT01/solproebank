
@extends('adminlte::page')

@section('title','Dashboar')

@section('content_header')
    <h1>Create donors</h1>
@stop

@section('content')

    <div class="container">

        <a href="{{ asset('menu') }}" class="btn btn-dark mb-3 mr-2">
            <i class="fa fa-home"></i>
            MENÚ
        </a>

        <a href="{{ asset('donantes') }}" 
            class="btn btn-info mb-3">
            <i class="fa fa-undo"></i>
            Gestión de Donantes
        </a>

        <div class="card">
            <div class="card-header text-center">
                CREAR DONANTE
            </div>
            <div v-if=" permisos.find( e => e === 21 ) " class="card-body p-5"> 

                <p v-if=" donante.fecha_nacimiento && !ValidarFecha(donante.fecha_nacimiento) " class="text-danger mb-3 text-right">La Fecha de nacimiento esta mal escrita.</p>
                <p v-if=" ValidarFecha(donante.fecha_nacimiento) && CalcularEdad(donante.fecha_nacimiento) > 17 && CalcularEdad(donante.fecha_nacimiento) < 66 " class="text-primary mb-3 text-right">La edad del donante es: @{{ CalcularEdad(donante.fecha_nacimiento) }} años.</p>
                <p v-if=" ValidarFecha(donante.fecha_nacimiento) && ( CalcularEdad(donante.fecha_nacimiento) > 65 || CalcularEdad(donante.fecha_nacimiento) < 18 ) " class="text-danger mb-3 text-right">La edad del donante es: @{{ CalcularEdad(donante.fecha_nacimiento) }} años, esta fuera de rango. </p>               


                <div class="card mb-4">
                    <div class="card-header text-success text-center">INFORMACIÓN BASICA</div>
                    <div class="card-body">



			<div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><i class="text-danger">*</i> Tipo de documento</label>
                                    <select v-model="donante.tipo_documento" class="form-control">
                                        <option value="CC">CC - CEDULA DE CIUDADANÍA</option>
                                        <option value="CE">CE - CEDULA DE EXTRANJERÍA</option>
                                        <option value="PA">PA - PASAPORTE</option>
                                        <option value="NUIP">NUIP - NÚMERO ÚNICO DE IDENTIFICACIÓN PERSONAL</option>
                                        <option value="PE">PE - PERMISO ESPECIAL DE PERMANENCIA</option>
                                    </select>
                                </div>
                            </div>

			    <div class="col-lg-6">
                                <div class="form-group">
                                    <label><i class="text-danger">*</i> Identificación</label>
                                    <input v-model="donante.identificacion" type="text" class="form-control">
                                </div>
                            </div>

                        </div>



                        <div class="row">
                    
                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label><i class="text-danger">*</i> Primer apellido</label>
                                    <input v-model="donante.primer_apellido" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Segundo apellido</label>
                                    <input v-model="donante.segundo_apellido" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label><i class="text-danger">*</i> Primer nombre</label>
                                    <input v-model="donante.primer_nombre" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label>Segundo nombre</label>
                                    <input v-model="donante.segundo_nombre" type="text" class="form-control">
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><i class="text-danger">*</i> Género</label>
                                    <select v-model="donante.genero" class="form-control">
                                        <option value="M">MASCULINO</option>
                                        <option value="F">FEMENINO</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><i class="text-danger">*</i> Fecha de nacimiento</label>
                                    <input
					@keydown.tab.prevent="DetenerLectura()" 
					v-model="donante.fecha_nacimiento" type="date" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><i class="text-danger">*</i> EPS</label>
                                    <select v-model="donante.eps" class="form-control">
                                        <option
                                            v-for="(c, i) in company" :key="i" 
                                            :value=" c.ID_COMPANY ">@{{ c.DES_COMPANY }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><i class="text-danger">*</i> Estado Civil</label>
                                    <select v-model="donante.estado_civil" class="form-control">
                                        <option value="1">SOLTERO(A)</option>
                                        <option value="2">CASADO(A)</option>
                                        <option value="3">UNION LIBRE</option>
                                        <option value="4">VIUDO(A)</option>
                                        <option value="5">NO INFORMA</option>
                                    </select>
                                </div>
                            </div>

			
			    <div class="col-lg-6">
                                <div class="form-group">
                                    <label><i class="text-danger">*</i> Ocupación</label>
                                    <select v-model="donante.profesion" class="form-control">
                                        <option
                                            v-for="(p, i) in profession" :key="i" 
                                            :value=" p.ID_PROFESSION ">@{{ p.DES_PROFESSION }}</option>
                                    </select>
                                </div>
                            </div>


                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><i class="text-danger">*</i> Lugar de nacimiento</label>
                                    <select v-model="donante.lugar_nacimiento" class="form-control">
                                        <option
                                            v-for="(b, i) in birthplace" :key="i" 
                                            :value=" b.ID_BIRTHPLACE ">@{{ b.DES_BIRTHPLACE }}</option>
                                    </select>
                                </div>
                            </div>


                        </div>

                    </div>
                </div> 



                <div class="card mb-4">
                    <div class="card-header text-success text-center">INFORMACIÓN DE CONTACTO</div>
                    <div class="card-body">
                    
                        <div class="row">
                        
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><i class="text-danger">*</i> Dirección de residencia</label>
                                    <input v-model="donante.direccion_residencia" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><i class="text-danger">*</i> Barrio</label>
                                    <input v-model="donante.barrio" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><i class="text-danger">*</i> Lugar de residencia</label>
                                    <select v-model="donante.lugar_residencia" class="form-control">
                                        <option
                                            v-for="(t, i) in town" :key="i" 
                                            :value=" t.ID_TOWN ">@{{ t.DES_TOWN }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><i class="text-danger">*</i> Departamento de residencia</label>
                                    <select v-model="donante.departamento_residencia" class="form-control">
                                        <option
                                            v-for="(s, i) in state" :key="i" 
                                            :value=" s.ID_STATE ">@{{ s.DES_STATE }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Teléfono Casa</label>
                                    <input v-model="donante.telefono_casa" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label>Teléfono Trabajo</label>
                                    <input v-model="donante.telefono_trabajo" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label><i class="text-danger">*</i> Teléfono Móvil</label>
                                    <input v-model="donante.telefono_movil" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label><i class="fa fa-envelope-o"></i> E-mail</label>
                                    <input v-model="donante.email" type="text" class="form-control">
                                </div>
                            </div>
                        
                        </div>

                        <hr>

                        <div class="row">

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label><i class="fa fa-whatsapp"></i> Whatsapp</label>
                                    <input v-model="donante.whatsapp" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label><i class="fa fa-facebook-official"></i> Facebook</label>
                                    <input v-model="donante.facebook" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label><i class="fa fa-instagram"></i> Instagram</label>
                                    <input v-model="donante.instagram" type="text" class="form-control">
                                </div>
                            </div>

                            <div class="col-lg-3">
                                <div class="form-group">
                                    <label><i class="fa fa-twitter-square"></i> Twitter</label>
                                    <input v-model="donante.twitter" type="text" class="form-control">
                                </div>
                            </div>

                        </div>

                    </div>
                </div>


                <div v-if="errores.length > 0" 
                    class="alert alert-danger mt-3" 
                    role="alert">
                    <div v-for="(e, i) in errores" :key="i">
                        <span class="d-block">@{{i+1}}. @{{e}}</span>
                    </div>
                </div>


                <button v-on:click="CrearDonante()" 
                    class="btn btn-info">
                    <i class="fa fa-floppy-o"></i>
                    Crear Donante
                </button>

                
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
                company:[],
                town:[],
                state:[],
		profession:[],
                birthplace:[],
                donante:{
		    tipo_documento:'CC',
                    genero:'',
                    identificacion:'',
                    primer_nombre:'',
		    segundo_nombre:'',
                    primer_apellido:'',
		    segundo_apellido:'',
                    fecha_nacimiento:'',
                    eps:'',
                    estado_civil:'',
                    direccion_residencia:'',
                    barrio:'',
                    lugar_residencia:'',
                    departamento_residencia:'',
                    telefono_casa:'',
                    telefono_trabajo:'',
                    telefono_movil:'',
                    email:'',
                    whatsapp:'',
                    facebook:'',
                    instagram:'',
                    twitter:'',
		    profesion:'',
                    lugar_nacimiento:''
                },
                errores:[]
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


                CompletarInformacionCreacion: async function()
                {

                    this.cargando = true;

                    try
                    {

                        let res = await axios.get(
                            '{{ asset("donantes/completar-informacion-creacion") }}',
                            {
                                headers:{
                                    'X-Requested-With' : 'XMLHttpRequest',
                                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                                }
                            }
                        );

                        
                        if(res.status === 202)
                        {
                            this.company = res.data.company;
                            this.town = res.data.town;
                            this.state = res.data.state;
			    this.profession = res.data.profession;
                            this.birthplace = res.data.birthplace;
                        }


                    }
                    catch(e)
                    {

                    }
                    finally
                    {
                        this.cargando = false;
                    }

                },


                CrearDonante: async function(){

                    this.errores = [];

                    try
                    {

                        this.cargando = true;

                        let res = await axios.post(
                            '{{ asset("donantes/crear") }}',
                            this.donante,
                            {
                                headers:{
                                    'X-Requested-With' : 'XMLHttpRequest',
                                    'X-CSRF-TOKEN' : '{{ csrf_token() }}'
                                }
                            }
                        );

                        if(res.status === 202) this.donante = {};
                        
                        if(res.status === 202)
                        {

                            let enlace = '{{ asset("donantes/calendario") }}'+'/'+res.data.id_person;

                            swal({ 
                                html:true, 
                                title:'Perfecto.', 
                                text:'El donante fue registrado correctamente. El código del donante es <span class="text-success">'+res.data.cod_donor+'</span>, si desea radicarle un ofrecimiento <a href="'+enlace+'">Presione aqui</a>',
                                type: 'success',
                                confirmButtonText:'No, luego tal vez.'
                            }, function(){
                                window.location.href = '{{ asset("donantes") }}';
                            });

                        }



                    }
                    catch(e)
                    {

                        if(e.response.status === 422)
                        {
                            var arregloAuxiliar = [];
                            Object.keys(e.response.data.errors)
                                .map(function(columna, index) {
                                    Array.prototype.push.apply(
                                        arregloAuxiliar, 
                                        e.response.data.errors[columna]
                                    );
                                });
                            this.errores = arregloAuxiliar;
                        }


			if(e.response.status === 428){
                            swal('Error','La identificación digitada ya esta asociada a otro donante.','error');
                        }


                    }
                    finally{
                        this.cargando = false;
                    }

                },


		CalcularEdad: function(FechaNacimiento){
                    var fechaNace = new Date(FechaNacimiento);
                    var fechaActual = new Date()
                    var mes = fechaActual.getMonth();
                    var dia = fechaActual.getDate();
                    var año = fechaActual.getFullYear();
                    fechaActual.setDate(dia);
                    fechaActual.setMonth(mes);
                    fechaActual.setFullYear(año);
                    edad = Math.floor(((fechaActual - fechaNace) / (1000 * 60 * 60 * 24) / 365));                
                    return edad;
                },


                ValidarFecha: function(FechaNacimiento){
                    var regEx = /^\d{4}-\d{2}-\d{2}$/;
                    return FechaNacimiento.match(regEx) != null;
                },


		DetenerLectura: function(){
                    this.donante.identificacion =
                        this.donante.identificacion.replace(/^0+/, '');
                    return false;
                }

                

            },
            created: function()
            {
                this.cargando = false;
                this.CompletarInformacionCreacion();
                this.ConsultarPermisos();

            }
        });

    </script>

@endsection
