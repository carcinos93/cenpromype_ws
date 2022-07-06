import apiLocal from "../../api/apiPortal";


export default class {
    baseUrl = '/cenpromye_ws';
    baseApi = '/cenpromype_ws/api';


    getAll(route, config) {
        let filterArray= [];
        let sort = config.multiSortMeta ?? [];
        return apiLocal.get(`${this.baseApi}/${route}`, { 
            params: { 
                first:  config.first || null ,
                rows:  config.rows || null, 
                filters: JSON.stringify( filterArray ),
                sorts: JSON.stringify( sort ) 
            } 
        });
    }
}