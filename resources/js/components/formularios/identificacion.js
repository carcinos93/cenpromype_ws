import Axios from 'axios';
import React, { Component } from 'react';
import { Campo } from '../campo.js';
export default  class Identificacion extends Component {
    constructor(props) {
        super(props);
        
        this.state = { paisesLista: null };

    }
    generarAnios() {
        let anios = [];
        let anio = new Date().getFullYear();
        for ( let i = ( anio - 112 ), total = anio; i<=total; i++ )
        {
            anios.push( { id: i, descripcion: i.toString() } );
        }

        return anios.sort( (a, b) => a.id < b.id  );
    }

   async paises() {
       
        let base = window['baseUrl'];
        const response = await Axios.get(base + "api/listas/paises");
        const data = await  response.data;

        return data;
    }

    componentDidMount(){ 
        if (!this.state.paisesLista) {
            this.paises()
            .then(data => this.setState({ paisesLista: data }))
            .catch(err => { this.setState({ paisesLista: [] }); console.log(err);   }  );
        }
    }

    render() {
        let genero = [ { key: 'M', name: 'Masculino' }, { key: 'F', name: 'Femenino' }, { key: 'O', name: 'Otro' } ];
        let anios = this.generarAnios();
        let paises = this.paises();


        return (
            <div className="p-fluid p-formgrid p-grid">
            <Campo rules={ { required: true } } errors={ this.props.errors } control={this.props.control} type="textbox" label="Nombre" name="nombre" cssClass="p-col-6" />
            <Campo rules={ { required: true } } errors={ this.props.errors } control={this.props.control}  type="textbox" label="Apellido" name="apellido" cssClass="p-col-6" />

            <Campo rules={ { required: true } } errors={ this.props.errors } control={this.props.control}  type="radio" label="Sexo" name="sexo" cssClass="p-col-12" items={ genero }  />

            <Campo rules={ { required: true } } errors={ this.props.errors } control={this.props.control}  type="dropdown" label="Año de nacimiento" name="anio" cssClass="p-col-12" items={ anios }  />   
            <Campo rules={ { required: true } } errors={ this.props.errors } control={this.props.control}  type="dropdown" label="Pais de residencia" name="pais_residencia" cssClass="p-col-12" items={ this.state.paisesLista }  />  
        
            </div>

        );
    }
}