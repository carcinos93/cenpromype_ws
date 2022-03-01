import React, { Component, useState } from 'react';
import ReactDOM from 'react-dom';
import { useForm, Controller } from 'react-hook-form';
import { TabView, TabPanel } from 'primereact/tabview';
import { Fieldset } from 'primereact/fieldset';
import { Divider } from 'primereact/divider';
import { Button } from 'primereact/button';
import { BlockUI } from 'primereact/blockui';
import Identificacion from './formularios/identificacion';
import Institucion from './formularios/institucion';
import Usuario from './formularios/usuario';
import Axios from 'axios';


export const Registro = () => {
  
    let [ activeIndex, setActiveIndex  ] = useState(0);
    const atras = (  ) => {
        let s = activeIndex-=1;
        setActiveIndex( s );
    }
    
    const siguiente = (  ) => {
        let s = activeIndex+=1;
        
        setActiveIndex( s );
    }
 
        let maxTabItems = 3;
 
        let defaultValues = {
            anio: null,
            apellido: "",
            confirmarPassword: "",
            correo: "",
            nombre: "",
            pais_residencia: null,
            password: "",
            recaptcha: "",
            recibirBoletin: 0,
            sexo: null,
            usuario: "",
            tipo_institucion: null,
            nombre_institucion: "",
            empresa_tamanyo: null,
            actividad_economica: null
        };
        let usuarioRef = React.useRef(null);
        const { control, formState: { errors, isSubmitting }, handleSubmit, reset, watch, getValues } = useForm({ defaultValues, mode: 'all' });    

        const onSubmit =(data) => {

            Axios.post( `${window.baseUrl}api/registro`, JSON.stringify(data), { headers: { 'Content-Type': 'application/json', 'Accept' : 'application/json' } }  )
            .then((response) => { 
                if (response.data.success) {
                    alert( response.data.message );
                    reset( defaultValues );
                    window.close();
                } else {
                    alert( response.data.message );
                     usuarioRef.current.reset();
                }
            })
            .catch((err) => console.log(err));
        }
        
    return ( 
        
        <div className="container w-100 h-100">
            <div className="row justify-content-center">
                <div className="col-md-12">
                    <div className="card">
                        <div className="card-header"> Registrarte </div>
                        <div className="card-body">
                        <form onSubmit={handleSubmit(onSubmit)} className="p-fluid">

                            <Divider align="center">
                                <span className="p-tag p-text-uppercase">Datos generales</span>
                            </Divider>

                            {<Identificacion getValues={getValues} errors={errors} control={control} />}
         
                            <Divider align="center">
                                <span className="p-tag p-text-uppercase">Datos de organización</span>
                            </Divider>
            
                            {<Institucion getValues={getValues} errors={errors} control={control}/> }
                
           
                            <Divider align="center">
                                <span className="p-tag p-text-uppercase">Datos de usuario</span>
                            </Divider>

                            <Usuario ref={usuarioRef} getValues={getValues} watch={watch} errors={errors} control={control}/>
                            <div className="p-field p-mt-5 p-fluid p-grid">
                                <div>
              
                                <button className={`p-button p-button-raised ${ isSubmitting ? 'p-disabled' : "" }`} disabled={isSubmitting} type="submit">Guardar</button>
                                </div>

                            </div>

                            {/* <TabView renderActiveOnly={false}  onTabChange={ (e) => setActiveIndex( e.index ) } activeIndex={ activeIndex } >
                                <TabPanel header="Datos generales">
                                   {<Identificacion getValues={getValues} errors={errors} control={control} />}
                                </TabPanel>
                                <TabPanel header="Datos de organización">
                                    {<Institucion getValues={getValues} errors={errors} control={control}/> }
                                </TabPanel>
                                <TabPanel header="Datos de usuario">
                                    <Usuario ref={usuarioRef} getValues={getValues} watch={watch} errors={errors} control={control}/>
                                </TabPanel>
                            </TabView>*/}

                        </form>                       
                        </div>
                        {/*<div className="card-footer">
                        { activeIndex > 0 &&  <Button label="Anterior" className="p-mr-2" onClick={ (e) => atras()   }   />}
                        {  activeIndex < (maxTabItems - 1 ) &&  <Button label="Siguiente" onClick={ (e) => siguiente()  }  />}
                        </div>*/}
                    </div>
                </div>
            </div>
        </div>
    );
    
}


if (document.getElementById('app')) {
    ReactDOM.render(<Registro />, document.getElementById('app'));
}
