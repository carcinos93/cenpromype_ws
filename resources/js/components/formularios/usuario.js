import Axios from 'axios';
import React, { Component, useRef} from 'react';
import {Campo} from '../campo';

export default class Usuario extends Component {
    
    constructor(props) {
        super(props);
        this.onDelayUsuario = this.onDelayUsuario.bind(this);
    }
    onDelayUsuario( e) {
       console.log(e.target.value);
    }   
    render() {
    
      
        return (
            <div className="p-fluid p-formgrid p-grid">
            <Campo errors={ this.props.errors } rules={ { required: true } } control={this.props.control} type="textbox" label="Correo" name="correo" cssClass="p-col-12" />
            <Campo errors={ this.props.errors } rules={ { required: true } } control={this.props.control} OnDelayChange={ (e) => this.onDelayUsuario( e ) }  on type="textbox" label="Nombre de usuario" name="usuario" cssClass="p-col-12" />
            <Campo errors={ this.props.errors } rules={ { required: true } } control={this.props.control}  type="password" label="Password" name="password" cssClass="p-col-12" />
            <Campo errors={ this.props.errors } rules={ { required: true } } control={this.props.control}  type="password" label="Corroborar contraseña" name="confirmarPassword" cssClass="p-col-12" />
            <Campo errors={ this.props.errors } rules={ { required: true } } control={this.props.control}  type="dropdown" label="¿Desea recibir boletines e información de interés?" name="recibirBoletin" items={ [ { id: "1", descripcion: "Si" }, { id:"0", descripcion: "No" } ] } cssClass="p-col-12" />
            <Campo errors={ this.props.errors } rules={ { required: true } } control={this.props.control}  type="recaptcha" label="" name="recaptcah" cssClass="p-col-12 p-m-auto"   />  
        
            <div className="p-field p-mt-5">
                <button className='p-button p-button-raised' type="submit">Guardar</button>
            </div>
            </div>

      
        );
    }
}