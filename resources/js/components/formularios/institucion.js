import Axios from 'axios';
import React, { Component, useState } from 'react';
import {Campo} from '../campo.js';

export default class Institucion extends Component {
    constructor(props) {
        super(props);
        this.state = { tipoInstitucionSeleccion: null, esEmpresa: false };
        this.tipoInstitucionChange = this.tipoInstitucionChange.bind(this);
    }

    tipoInstitucionChange(e) {
        this.setState({ tipoInstitucionSeleccion: e.value, esEmpresa:  (e.value == 7)  });
    }



    render() {
        let tipoInstitucion = [  { id: 1, descripcion: 'Academia' },
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
       ];

       let empresaTamahno = [  { id: 1, descripcion: 'Microempresa' },
       { id: 2, descripcion: 'Pequeña empresa' },
       { id: 3, descripcion: 'Mediana empresa' },
       { id: 4, descripcion: 'Gran empresa' }       ];


       let actividadEconomica = this.listaActividadesEconomicas();

        return (
            <div className="p-fluid p-formgrid p-grid">
            <Campo rules={ { required: true } } errors={ this.props.errors } control={this.props.control} OnChange={ this.tipoInstitucionChange }  type="dropdown"  label="Tipo de institución" name="tipo_institucion" cssClass="p-col-6" items={ tipoInstitucion }  />   
            
            <Campo rules={ { required: true } } errors={ this.props.errors } control={this.props.control} type="textbox" label="Nombre de institución" name="nombre_institucion" cssClass="p-col-6" />
            
            { this.state.esEmpresa ? <Campo rules={ { required: true } } errors={ this.props.errors } control={this.props.control}  type="dropdown"  label="Tamaño de empresa" name="empresa_tamanyo" cssClass="p-col-6" items={ empresaTamahno }  /> : <div/> }    
            { this.state.esEmpresa ? <Campo rules={ { required: true } } errors={ this.props.errors } control={this.props.control}  type="dropdown"  label="Actividad económica" name="actividad_economica" cssClass="p-col-6" items={ actividadEconomica }  /> : <div/> } 
            
            </div>
        );
    }

    listaActividadesEconomicas() {
        return [
            { id: 1, descripcion: '1. Sector primario - Agricultura, ganadería, caza y servicios relacionados' },
            { id: 2, descripcion: '2. Sector primario – Silvicultura y explotación forestal' },
            { id: 3, descripcion: '3. Sector primario - pesca y acuicultura' },
            { id: 4, descripcion: '4. Industria extractiva - extracción de carbón de antracita y lignito' },
            { id: 5, descripcion: '5. Industria extractiva - Extracción de petróleo crudo y gas natural' },
            { id: 6, descripcion: '6. Industria extractiva - Extracción de minerales metálicos' },
            { id: 7, descripcion: '7. Industria extractiva - Otras industrias extractivas' },
            { id: 8, descripcion: '8. Industria extractiva - Actividades de apoyo a las industrias extractivas' },
            { id: 9, descripcion: '9. Industria manufacturera - Industria alimentaria' },
            { id: 10, descripcion: '10. Industria manufacturera – Fabricación de bebidas' },
            { id: 11, descripcion: '11. Industria manufacturera - Industria tabacalera' },
            { id: 12, descripcion: '12. Industria manufacturera - Industria textil' },
            { id: 13, descripcion: '13. Industria manufacturera - Confección de prendas de vestir' },
            { id: 14, descripcion: '14. Industria manufacturera - Industria del cuero y el calzado' },
            { id: 15, descripcion: '15. Industria manufacturera - Industria de la madera y el corcho, excepto muebles; cestería y espartería' },
            { id: 16, descripcion: '16. Industria manufacturera - Industria papelera' },
            { id: 17, descripcion: '17. Industria manufacturera - Artes gráficas y reproducción de soportes grabados' },
            { id: 18, descripcion: '18. Industria manufacturera - plantas de coque y refinación de petróleo' },
            { id: 19, descripcion: '19. Industria manufacturera - Industria química' },
            { id: 20, descripcion: '20. Industria manufacturera - Fabricación de productos farmacéuticos' },
            { id: 21, descripcion: '21. Industria manufacturera – Fabricación de productos de caucho y plástico' },
            { id: 22, descripcion: '22. Industria manufacturera – Fabricación de otros productos minerales no metálicos' },
            { id: 23, descripcion: '23. Industria manufacturera - Metalurgia; fabricación de productos de hierro, acero y ferroaleaciones' },
            { id: 24, descripcion: '24. Industria manufacturera – Fabricación de productos metálicos, excepto maquinaria y equipo' },
            { id: 25, descripcion: '25. Industria manufacturera – Fabricación de productos informáticos, electrónicos y ópticos' },
            { id: 26, descripcion: '26. Industria manufacturera – Fabricación de equipos y suministros eléctricos' },
            { id: 27, descripcion: '27. Industria manufacturera – Fabricación de maquinaria y equipo' },
            { id: 28, descripcion: '28. Industria manufacturera – Fabricación de remolques y semirremolques para vehículos de motor' },
            { id: 29, descripcion: '29. Industria manufacturera – fabricación de otros materiales de transporte' },
            { id: 30, descripcion: '30. Industria manufacturera - fabricación de muebles' },
            { id: 31, descripcion: '31. Industria manufacturera - otras industrias manufactureras' },
            { id: 32, descripcion: '32. Industria manufacturera - reparación e instalación de maquinaria y equipo' },
            { id: 33, descripcion: '33. Energía, agua, reciclaje - suministro de electricidad, gas, vapor y aire' },
            { id: 34, descripcion: '34. Energía, agua, reciclaje - Recogida, purificación y distribución de agua' },
            { id: 35, descripcion: '35. Energía, agua, reciclaje - Recogida y tratamiento de aguas residuales' },
            { id: 36, descripcion: '36. Energía, agua, reciclaje - Recogida, tratamiento y eliminación de residuos, recuperación.' },
            { id: 37, descripcion: '37. Energía, agua, reciclaje - Actividades de descontaminación y otros servicios de gestión de residuos' },
            { id: 38, descripcion: '38. Construcción - Construcción de edificios' },
            { id: 39, descripcion: '39. Construcción - Ingeniería Civil' },
            { id: 40, descripcion: '40. Construcción - Actividades de construcción especializadas' },
            { id: 41, descripcion: '41. Comercio - Venta y reparación de vehículos automotores y motocicletas' },
            { id: 42, descripcion: '42. Comercio: comercio al por mayor e intermediarios comerciales, excepto vehículos de motor y motocicletas' },
            { id: 43, descripcion: '43. Comercio - comercio al por menor, excepto de vehículos de motor y motocicletas' },
            { id: 44, descripcion: '44. Servicios - transporte terrestre y oleoducto' },
            { id: 45, descripcion: '45. Servicios - Transporte marítimo y por vías navegables interiores' },
            { id: 46, descripcion: '46. Servicios - Transporte aéreo' },
            { id: 47, descripcion: '47. Servicios - almacenamiento y actividades relacionadas con el transporte' },
            { id: 48, descripcion: '48. Servicios - Actividades postales y postales' },
            { id: 49, descripcion: '49. Servicios - servicio de alojamiento' },
            { id: 50, descripcion: '50. Servicios - servicios de alimentos y bebidas' },
            { id: 51, descripcion: '51. Servicies – edición' },
            { id: 52, descripcion: '52. Servicios - Actividades cinematográficas, de vídeo y programas de televisión, grabación de sonido y edición musical' },
            { id: 53, descripcion: '53. Servicios - Programación de radio y televisión y actividades de radiodifusión' },
            { id: 54, descripcion: '54. Servicios – Telecomunicaciones' },
            { id: 55, descripcion: '55. Servicios - Programación, consultoría y otras actividades relacionadas con la informática' },
            { id: 56, descripcion: '56. Servicios - Servicios de información' },
            { id: 57, descripcion: '57. Servicios - servicios financieros, excepto seguros y fondos de pensiones' },
            { id: 58, descripcion: '58. Servicios - seguros, reaseguros y fondos de pensiones, excepto la seguridad social obligatoria' },
            { id: 59, descripcion: '59. Servicios - Actividades auxiliares de los servicios financieros y de seguros' },
            { id: 60, descripcion: '60. Servicios - Actividades inmobiliarias' },
            { id: 61, descripcion: '61. Servicios - Actividades legales y contables' },
            { id: 62, descripcion: '62. Servicios - Actividades de la sede central; actividades de consultoría de gestión empresarial' },
            { id: 63, descripcion: '63. Servicios - servicios técnicos de arquitectura e ingeniería, pruebas y análisis técnicos' },
            { id: 64, descripcion: '64. Servicios - Investigación y desarrollo' },
            { id: 65, descripcion: '65. Servicios - Publicidad e investigación de mercado' },
            { id: 66, descripcion: '66. Servicios - Otras actividades profesionales, científicas y técnicas' },
            { id: 67, descripcion: '67. Servicios - Actividades veterinarias' },
            { id: 68, descripcion: '68. Servicios - Actividades de alquiler' },
            { id: 69, descripcion: '69. Servicios - Actividades relacionadas con el empleo' },
            { id: 70, descripcion: '70. Servicios - Actividades de las agencias de viajes de reserva de operadores turísticos y actividades relacionadas' },
            { id: 71, descripcion: '71. Servicios - Actividades de seguridad e investigación' },
            { id: 72, descripcion: '72. Servicios - Servicios a edificios y actividades de jardinería' },
            { id: 73, descripcion: '73. Servicios - Servicios a edificios y actividades de jardinería' },
            { id: 74, descripcion: '74. Servicios - Administración pública y defensa obligatoria de la seguridad social' },
            { id: 75, descripcion: '75. Servicios – educación' },
            { id: 76, descripcion: '76. Servicios – Actividades sanitarias' },
            { id: 77, descripcion: '77. Servicios - Asistencia en establecimientos residenciales' },
            { id: 78, descripcion: '78. Servicios - Actividades de servicios sociales sin alojamiento' },
            { id: 79, descripcion: '79. Servicios - Actividades de servicios sociales sin alojamiento' },
            { id: 80, descripcion: '80. Servicios - Bibliotecas archivos, museos y otras actividades culturales' },
            { id: 81, descripcion: '81. Servicios - Actividades de juego y apuestas' },
            { id: 82, descripcion: '82. Servicios - Actividades deportivas, recreativas y de entretenimiento' },
            { id: 83, descripcion: '83. Servicios - Actividades Asociativas' },
            { id: 84, descripcion: '84. Servicios - Reparación de computadoras, efectos personales y artículos domésticos' },
            { id: 85, descripcion: '85. Servicios - otros servicios personales' },
            { id: 86, descripcion: '86. Servicios - Actividades domésticas como empleados del personal doméstico' },
            { id: 87, descripcion: '87. Servicios - Actividades domésticas como productores de bienes y servicios para su propio uso' },
            { id: 88, descripcion: '88. Servicios - Actividades de organizaciones y organismos extraterritoriales' },
            { id: 89, descripcion: '89. otras actividades no contempladas' }           
        ];
    }

}