import Axios from 'axios';
import React, { Component, useRef} from 'react';
import {Campo} from '../campo';

export default class Usuario extends Component {
    



    constructor(props) {
        super(props);
        this.onDelayUsuario = this.onDelayUsuario.bind(this);

        this.recaptchaRef = React.createRef();
        this.reset = this.reset.bind(this);
    }

    onDelayUsuario( e) {
       //console.log(e.target.value);
      
    } 
    
    reset() {
        this.recaptchaRef.current.reset();
    }

    async existeUsuario(value) {
        let base = window['baseUrl'];
        const response = await Axios.get(base + "api/existeUsuario", { params: { usuario: value } });
        return response.data == 0;
        //const data = await response.data;
        //console.log(data);
    }
    
    render() {
    
      
        return (
            <div className="p-fluid p-formgrid p-grid">
            <Campo errors={ this.props.errors } rules={ { required: true, pattern: { value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i, message: "Dirección de correo invalida" } } } control={this.props.control} type="textbox" label="Correo" name="correo" cssClass="p-col-6" />
            <Campo errors={ this.props.errors } rules={ { required: true, validate: async (v) => { const s = await this.existeUsuario( v ); return s || `El usuario ${v} ya existe`; }  } } control={this.props.control} OnDelayChange={ (e) => this.onDelayUsuario( e ) }   type="delayTextBox" label="Nombre de usuario" name="usuario" cssClass="p-col-6" />
            <Campo errors={ this.props.errors } rules={ { required: true } } control={this.props.control}  type="password" label="Contraseña" name="password" cssClass="p-col-12" />
            <Campo errors={ this.props.errors } rules={ { required: true , validate: (v) => { return this.props.getValues('password') == v || "No coincide con la contraseña" } } } control={this.props.control}  type="password" label="Corroborar contraseña" name="confirmarPassword" cssClass="p-col-12" />
            <Campo errors={ this.props.errors } rules={ { required: true } } control={this.props.control}  type="dropdown" label="¿Desea recibir boletines e información de interés?" name="recibirBoletin" items={ [ { id: 1, descripcion: "Si" }, { id: 0, descripcion: "No" } ] } cssClass="p-col-6" />
            <Campo referencia={ this.recaptchaRef } errors={ this.props.errors } rules={ { required: true } } control={this.props.control}  type="recaptcha" label="" name="recaptcha" cssClass="p-col-12 p-m-auto"   />  
        

            </div>

      
        );
    }
}