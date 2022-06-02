import Axios from 'axios';
import React, { Component, useState } from 'react';
import { Campo } from '../campo';

export default class Institucion extends Component {
    constructor(props) {
        super(props);
        this.state = {
            tipoInstitucionSeleccion: null,
            esEmpresa: false,
            tipoInstitucion: null,
            empresaTamahno: null,
            actividadEconomica: [],
            sectorEconomico: null,
            selectedSector: 0
        };
        this.tipoInstitucionChange = this.tipoInstitucionChange.bind(this);
        this.listaActividadesEconomicas = this.listaActividadesEconomicas.bind(this);
        this.listaTipoInstituciones = this.listaTipoInstituciones.bind(this);
        this.listaSectoresEconomicas = this.listaSectoresEconomicas.bind(this);



        this.listaSectoresEconomicas();
        this.listaTipoInstituciones();
        //this.listaActividadesEconomicas();

    }

    tipoInstitucionChange(e) {
        this.setState({ tipoInstitucionSeleccion: e.value, esEmpresa: (e.value == 7) });
    }



    render() {
        /* let tipoInstitucion = [  { id: 1, descripcion: 'Academia' },
         { id: 2, descripcion: 'Centro de innovación' },
         { id: 3, descripcion: 'Centro de servicios de desarrollo empresarial' },
         { id: 4, descripcion: 'Consejo u organismo regional' },
         { id: 5, descripcion: 'Cooperación internacional' },
         { id: 6, descripcion: 'Emprendimiento' },
         { id: 7, descripcion: 'Empresa', esEmpresa : true },
         { id: 8, descripcion: 'Gremial o asociación' },
         { id: 9, descripcion: 'Institución nacional MIPYME' },
         { id: 10, descripcion: 'Observatorio nacional o regional' },
         { id: 11, descripcion: 'Organismo internacional' },
         { id: 12, descripcion: 'Promotora de exportaciones' },
         { id: 13, descripcion: 'Otro' }
        ];*/

        let empresaTamahno = [{ id: 1, descripcion: 'Microempresa' },
        { id: 2, descripcion: 'Pequeña empresa' },
        { id: 3, descripcion: 'Mediana empresa' },
        { id: 4, descripcion: 'Gran empresa' }
        ];

        // let actividadEconomica = this.listaActividadesEconomicas();

        return (< div className="p-fluid p-formgrid p-grid" >
            <Campo rules={{ required: true }} errors={this.props.errors} control={this.props.control}
                OnChange={this.tipoInstitucionChange} type="dropdown"
                label="Tipo de institución" name="tipo_institucion"
                cssClass="p-col-6" items={this.state.tipoInstitucion}
            />

            <Campo rules={
                { required: true }
            }
                errors={this.props.errors}
                control={this.props.control}
                type="textbox"
                label="Nombre de institución"
                name="nombre_institucion"
                cssClass="p-col-6" />

            {
                this.state.esEmpresa ? < Campo rules={
                    { required: true }
                }
                    errors={this.props.errors}
                    control={this.props.control}
                    type="dropdown"
                    label="Tamaño de empresa"
                    name="empresa_tamanyo"
                    cssClass="p-col-6"
                    items={empresaTamahno}
                /> : <div />
            }

            {
                this.state.esEmpresa ? < Campo rules={
                    { required: true }
                }
                    errors={this.props.errors}
                    control={this.props.control}
                    type="dropdown"
                    label="Sector"
                    name="sector_economico"
                    cssClass="p-col-6"
                    OnChange={
                        (e) => {
                            this.setState({ selectedSector: e.value });
                            this.listaActividadesEconomicas(e.value);
                        }
                    }
                    items={this.state.sectorEconomico}
                /> : <div />
            }

            {
                this.state.esEmpresa ? < Campo rules={
                    { required: true }
                }
                    errors={this.props.errors}
                    control={this.props.control}
                    type="dropdown"
                    label="Actividad económica"
                    name="actividad_economica"
                    cssClass="p-col-6"
                    items={this.state.actividadEconomica}
                /> : <div />
            } </div>
        );
    }

    listaActividadesEconomicas(sector) {
        this.setState({ actividadEconomica: null });
        this.dataRetorno(`api/listas/empresa-actividad/${sector}`).then((resp) => {
            this.setState({ actividadEconomica: resp });
        });
    }

    listaSectoresEconomicas() {
        this.dataRetorno("api/listas/empresa-sector").then((resp) => {
            this.state.sectorEconomico = resp;
        });
    }

    listaTipoInstituciones() {
        return this.dataRetorno("api/listas/tipo-instituciones").then((resp) => {
            this.state.tipoInstitucion = resp;
        }).finally(() => {
            this.setState({});
        });

    }

    async dataRetorno(api) {
        let base = window['baseUrl'];
        const response = await Axios.get(base + api);
        const data = await response.data;
        return data;
    }



}