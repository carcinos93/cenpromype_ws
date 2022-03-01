import React, { Component, useState } from 'react';
import { InputText } from 'primereact/inputtext';
import { RadioButton } from 'primereact/radiobutton';
import { Field } from 'react-final-form';
export default class BaseCampo extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <Field name={ this.props.name } type={this.props.type} render={({ input, meta }) => (
                <div className={`p-field ${ this.props.cssClass }` }>
                <label htmlFor={this.props.name} >  { this.props.label } </label>
                    { this.props.children }
                </div>
            )} /> 
        );
    }
}