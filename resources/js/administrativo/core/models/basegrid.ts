export default class BaseGridConf {
    modoSeleccion: string;
    permitirSeleccion: boolean;
    multiple: boolean;
    dataTable: { columns: [] };
    comandos: [];
    llavePrimaria: { columna: string, llave: string };
    botonesEstado: any
}