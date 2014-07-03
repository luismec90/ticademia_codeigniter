$(function() {
    $('#table-javascript').bootstrapTable({
        method: 'get',
        url: '../ranking/rankingJson/'+idCursoGlobal,
        striped: true,
        pagination: true,
        pageSize: 10,
        pageList: [10, 20, 50, 100, 200,500],
        search:true,
        showColumns:true,
        columns: [{
                field: 'posicion',
                title: 'Pos'
            },{
                field: 'avatar',
                title: 'Avatar'
            }, {
                field: 'nombre',
                title: 'Nombre',
                sortable: true
            }, {
                field: 'puntaje',
                title: 'Puntaje',
                sortable: true,
            }, {
                field: 'last_login',
                title: 'Último acceso',
                sortable: true,
            },{
                field: 'logins',
                title: 'Cantidad de accesos',
                sortable: true,
            } ,{
                field: 'total_time',
                title: 'Tiempo logueado',
                sortable: true,
            },{
                field: 'logros',
                title: 'Logros obtenidos',
                sortable: true,
            },{
                field: 'modulos',
                title: 'Módulos apro.',
                sortable: true,
            },{
                field: 'evaluaciones',
                title: 'Ev. apro.',
                sortable: true,
            },{
                field: 'materiales',
                title: 'Materiales',
                sortable: true,
            },{
                field: 'videos',
                title: 'Videos',
                sortable: true,
            },{
                field: 'foro',
                title: 'Publ. en foro',
                sortable: true,
            } ,{
                field: 'muro',
                title: 'Publ. en muro',
                sortable: true,
            }
        ]
    });
});