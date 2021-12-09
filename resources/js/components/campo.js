import React, { Component, useCallback, useState } from 'react';
import { InputText } from 'primereact/inputtext';
import { RadioButton } from 'primereact/radiobutton';
import { Dropdown } from 'primereact/dropdown';
import { useForm, Controller } from 'react-hook-form';
import ReCAPTCHA from "react-google-recaptcha";
export const Campo = ({type, name,label,cssClass,items, rules, control, OnDelayChange, errors, OnChange } ) =>  {
  
    const [timer, setTimer  ] = useState(null);
    const [ selectedRadio, setSelectedRadio ] = useState(null);
    const [ selectedDropDown, setSelectedDropDown ] = useState(null);
    
    //this.state = { timer: null, selectedRadio: { key: null }, selectedDropDown: null };
    const OnControlChange =(e) => {
        if (typeof OnChange == "function" ) {
            OnChange(e);
        }
    }



    const delay = useCallback(( e ) => {
        e.persist();
        if ( typeof OnDelayChange != "function" ) {
            return;
        }
        if ( timer ) {
            clearTimeout(timer);
            setTimer( null );
        }
        let timeout = setTimeout( function () {
            if ( typeof OnDelayChange == "function" ) {
                setTimer( null );
                OnDelayChange( e ); 
            }}, 2000  );
        setTimer( timeout );
    });

  
    const getFormErrorMessage = (name, label) => {
        //console.log(errors);
        return errors[name] && <small className="p-error"> {label} es requerido </small>
    };

    const controlField = ( field  ) =>  {
        switch (type) {
            case 'textbox':
                return  ( 
                    <span className={ timer && typeof OnDelayChange  == "function" ?  "p-input-icon-left" : ""}>
                             { timer && typeof OnDelayChange  == "function" ? <i className="pi pi-spin pi-spinner"></i> : <i/> }
                            <InputText {...field} id={name}  onKeyDown={(e) =>  delay(e) }  /> 
                    </span>
                    )
            case 'radio': 
            return ( 
                <div className="p-formgroup-inline">
                    {
                        (!items ? [] : items ).map(( value, i) => {
                            return (
                                <div key={value.key} className="p-field-radiobutton">
                                <RadioButton  name={name} id={name + '_' + i} onChange={(e) => { field.onChange(e.value); setSelectedRadio(e.value); }}  checked={selectedRadio === value.key}  value={value.key}  /> 
                                <label htmlFor={value.key}>{value.name}</label>  </div> 
                            )
                        })
                    }
                </div>
            )
            case 'checkbox':
                return <InputText {...field}  type="checkbox"  /> 
            case 'dropdown':
                /** los valores de optionLabel deben ser string, si es numero debe ser convertido a string  **/
                return ( !items ? <p> <i className="pi pi-spin pi-spinner"></i> Cargando...</p>  : 
                <Dropdown id={name} name={name}  
                optionLabel="descripcion" optionValue="id" value={selectedDropDown || ''} 
                 options={!items ? [] : items} 
                 onChange={(e) =>  { field.onChange(e.value); OnControlChange(e); setSelectedDropDown(e.value)  }  } /> ) 
            
            case 'password': 
                return  <InputText {...field} id={name} type="password"  /> 

            case 'recaptcha': 

                    return ( 
                        <div className='p-m-auto p-d-inline'>
                            <ReCAPTCHA onChange={ (e) => { field.onChange(e);  } } sitekey="6LdfFHAaAAAAAIvUfxf6viOCpYKVzfLBp0WhNi-_" />
                        </div>
    
                    )
                default: 
            return null
            }
    }

        //
        return (
            <div className={`p-field ${ cssClass }` }>
                <Controller rules={ rules } control={control}  name={ name } render={({ field, fieldState }) => (
                    <div>
                         <label htmlFor={name} >  { label } </label>
                         { controlField( field ) }
                    </div>
                )} /> 
                 {getFormErrorMessage( name, label )}
            </div>    
        );
    
}


/***
 *  <BaseCampo name={name} cssClass={this.props.cssClass} label={this.props.label} >
              { this.control() }
                </BaseCampo>  
 */