<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Fill_model extends CI_Model {

    public function __construct() {
        $this->load->database();
    }

    function poblarBD() {
        $this->afiliacion();
        $this->nivel();
        $this->usuario();
        $this->asignatura();
        $this->curso();
        $this->usuario_x_curso();
        $this->modulo();
        $this->material();
        $this->tipo_evaluacion();
        $this->evaluacion();
        $this->usuario_x_evaluacion();
        $this->usuario_x_modulo();
        $this->tema_foro();
        $this->respuesta();
        $this->logro();
        $this->usuario_curso_logro();
        $this->muro();
    }

    private function asignatura() {
        $this->db->empty_table('asignatura');
        $data = array(
            'id_asignatura' => 1,
            'nombre' => 'Cálculo Integral',
            'descripcion' => 'Bienvenidos al curso de Cálculo Diferencial. En este curso se enseñan los conceptos matemáticos básicos que los ingenieros y científicos usamos para entender y cuantificar el mundo. ',
            'tabla_contenido' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum. Mei facer fabulas ut, id eum stet regione. An posse albucius invidunt qui, nam mundi ceteros vulputate et. Ex unum reprehendunt his. Eam accusata mnesarchum an, eu his doming accusata. Et est consulatu assueverit, sit ancillae suavitate te. Ex omnium timeam indoctum vix, in viris deleniti eum, has discere recteque persequeris eu. Eum ne solet oblique tincidunt. Movet latine iuvaret eos ut, dicit regione in mei. Ea tibique corpora atomorum vel, dicant detracto intellegat vel et, graeco aliquid propriae ea ius. Odio paulo reprimique vix ex. Usu habemus dolores tacimates ex, ad aliquip fastidii sea, saepe forensibus ex duo. Has ullum causae dissentiet no, cum nostrud voluptatibus cu. Justo possit minimum duo cu, sea eu dolorum intellegat. Noster repudiare mea ut, cu ius appareat rationibus. Nec aliquip mediocrem ut, ius alterum concludaturque te. Vix no melius suavitate. Te facilis percipitur nec, minim forensibus mei eu. Te has maiorum percipitur. Pro bonorum detracto repudiandae at. Vim ferri eruditi appellantur an. Nam utinam eligendi lucilius ea, ad sea agam probatus. Ius homero commune id, te eam agam accusata.',
            'idioma' => 'Español',
            'prerequisitos' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum. Mei facer fabulas ut, id eum stet regione. An posse albucius invidunt qui, nam mundi ceteros vulputate et. Ex unum reprehendunt his. Eam accusata mnesarchum an, eu his doming accusata. Et est consulatu assueverit, sit ancillae suavitate te. Ex omnium timeam indoctum vix, in viris deleniti eum, has discere recteque persequeris eu. Eum ne solet oblique tincidunt. Movet latine iuvaret eos ut, dicit regione in mei. Ea tibique corpora atomorum vel, dicant detracto intellegat vel et, graeco aliquid propriae ea ius. Odio paulo reprimique vix ex. Usu habemus dolores tacimates ex, ad aliquip fastidii sea, saepe forensibus ex duo. Has ullum causae dissentiet no, cum nostrud voluptatibus cu. Justo possit minimum duo cu, sea eu dolorum intellegat. Noster repudiare mea ut, cu ius appareat rationibus. Nec aliquip mediocrem ut, ius alterum concludaturque te. Vix no melius suavitate. Te facilis percipitur nec, minim forensibus mei eu. Te has maiorum percipitur. Pro bonorum detracto repudiandae at. Vim ferri eruditi appellantur an. Nam utinam eligendi lucilius ea, ad sea agam probatus. Ius homero commune id, te eam agam accusata.'
        );
        $this->db->insert('asignatura', $data);

        $data = array(
            'id_asignatura' => 2,
            'nombre' => 'Fisica mecanica',
            'descripcion' => 'La física mecánica se complementa con los temas de trabajo y energía donde se incluye la energía cinética y la potencial, el momento lineal',
            'tabla_contenido' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum. Mei facer fabulas ut, id eum stet regione. An posse albucius invidunt qui, nam mundi ceteros vulputate et. Ex unum reprehendunt his. Eam accusata mnesarchum an, eu his doming accusata. Et est consulatu assueverit, sit ancillae suavitate te. Ex omnium timeam indoctum vix, in viris deleniti eum, has discere recteque persequeris eu. Eum ne solet oblique tincidunt. Movet latine iuvaret eos ut, dicit regione in mei. Ea tibique corpora atomorum vel, dicant detracto intellegat vel et, graeco aliquid propriae ea ius. Odio paulo reprimique vix ex. Usu habemus dolores tacimates ex, ad aliquip fastidii sea, saepe forensibus ex duo. Has ullum causae dissentiet no, cum nostrud voluptatibus cu. Justo possit minimum duo cu, sea eu dolorum intellegat. Noster repudiare mea ut, cu ius appareat rationibus. Nec aliquip mediocrem ut, ius alterum concludaturque te. Vix no melius suavitate. Te facilis percipitur nec, minim forensibus mei eu. Te has maiorum percipitur. Pro bonorum detracto repudiandae at. Vim ferri eruditi appellantur an. Nam utinam eligendi lucilius ea, ad sea agam probatus. Ius homero commune id, te eam agam accusata.',
            'idioma' => 'Español',
            'prerequisitos' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum. Mei facer fabulas ut, id eum stet regione. An posse albucius invidunt qui, nam mundi ceteros vulputate et. Ex unum reprehendunt his. Eam accusata mnesarchum an, eu his doming accusata. Et est consulatu assueverit, sit ancillae suavitate te. Ex omnium timeam indoctum vix, in viris deleniti eum, has discere recteque persequeris eu. Eum ne solet oblique tincidunt. Movet latine iuvaret eos ut, dicit regione in mei. Ea tibique corpora atomorum vel, dicant detracto intellegat vel et, graeco aliquid propriae ea ius. Odio paulo reprimique vix ex. Usu habemus dolores tacimates ex, ad aliquip fastidii sea, saepe forensibus ex duo. Has ullum causae dissentiet no, cum nostrud voluptatibus cu. Justo possit minimum duo cu, sea eu dolorum intellegat. Noster repudiare mea ut, cu ius appareat rationibus. Nec aliquip mediocrem ut, ius alterum concludaturque te. Vix no melius suavitate. Te facilis percipitur nec, minim forensibus mei eu. Te has maiorum percipitur. Pro bonorum detracto repudiandae at. Vim ferri eruditi appellantur an. Nam utinam eligendi lucilius ea, ad sea agam probatus. Ius homero commune id, te eam agam accusata.'
        );
        $this->db->insert('asignatura', $data);
    }

    private function nivel() {
        $this->db->empty_table('nivel');
        $data = array(
            'id_nivel' => 1,
            'nombre' => 'Nivel 1',
            'imagen' => '1.jpg',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea'
        );
        $this->db->insert('nivel', $data);

        $data = array(
            'id_nivel' => 2,
            'nombre' => 'Nivel 2',
            'imagen' => '2.jpg',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea'
        );
        $this->db->insert('nivel', $data);

        $data = array(
            'id_nivel' => 3,
            'nombre' => 'Nivel 3',
            'imagen' => '3.jpg',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea'
        );
        $this->db->insert('nivel', $data);

        $data = array(
            'id_nivel' => 4,
            'nombre' => 'Nivel 4',
            'imagen' => '4.jpg',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea'
        );
        $this->db->insert('nivel', $data);

        $data = array(
            'id_nivel' => 5,
            'nombre' => 'Nivel 5',
            'imagen' => '5.jpg',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea'
        );
        $this->db->insert('nivel', $data);
    }

    private function curso() {
        $this->db->empty_table('curso');
        $data = array(
            'id_curso' => 1,
            'id_usuario' => 2,
            'id_asignatura' => 1,
            'fecha_inicio' => '2014-01-07',
            'niveles' => '5',
            'fecha_fin' => '2014-05-07',
            'umbral' => 0.6
        );
        $this->db->insert('curso', $data);

        $data = array(
            'id_curso' => 2,
            'id_usuario' => 3,
            'id_asignatura' => 2,
            'fecha_inicio' => '2014-03-07',
            'niveles' => '5',
            'fecha_fin' => '2014-010-07',
            'umbral' => 0.6
        );
        $this->db->insert('curso', $data);
    }

    private function afiliacion() {
        $this->db->empty_table('afiliacion');
        $data = array(
            'id_afiliacion' => 1,
            'nombre' => 'Universidad Nacional de Colombia - Sede Medellín'
        );
        $this->db->insert('afiliacion', $data);

        $data = array(
            'id_afiliacion' => 2,
            'nombre' => 'Centro de Educación Militar'
        );
        $this->db->insert('afiliacion', $data);

        $data = array(
            'id_afiliacion' => 3,
            'nombre' => 'Centro Educacional de Cómputos y Sistemas'
        );
        $this->db->insert('afiliacion', $data);

        $data = array(
            'id_afiliacion' => 4,
            'nombre' => 'Colegio de Estudios Superiores de Administración'
        );
        $this->db->insert('afiliacion', $data);
    }

    private function usuario() {
        $this->db->empty_table('usuario');
        $data = array(
            'id_usuario' => 1,
            'id_afiliacion' => 1,
            'nombres' => 'Luis Fernando',
            'apellidos' => 'Montoya Gómez',
            'correo' => 'luismec91@gmail.com',
            'imagen' => '1.jpg',
            'usuario' => 'estudiante1',
            'password' => sha1("123"),
            'rol' => 'estudiante', 'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 2,
            'id_afiliacion' => 1,
            'nombres' => 'Julian',
            'apellidos' => 'Moreno Cadavid',
            'correo' => 'jmoreno@gmail.com',
            'imagen' => 'default.png',
            'usuario' => 'profesor1',
            'password' => sha1("123"),
            'rol' => 'profesor',
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 3,
            'id_afiliacion' => 1,
            'nombres' => 'Francisco Javier',
            'apellidos' => 'Moreno',
            'correo' => 'fjmoreno@gmail.com',
            'imagen' => 'default.png',
            'usuario' => 'profesor2',
            'password' => sha1("123"),
            'rol' => 'profesor',
            'activo' => 1
        );
        $this->db->insert('usuario', $data);


        $data = array(
            'id_usuario' => 4,
            'id_afiliacion' => 1,
            'nombres' => 'Roger A',
            'apellidos' => 'Cadavid',
            'correo' => 'alejo@gmail.com',
            'imagen' => 'default.png',
            'usuario' => 'estudiante2',
            'password' => sha1("123"),
            'rol' => "estudiante",
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 5,
            'id_afiliacion' => 1,
            'nombres' => 'Juan Camilo',
            'apellidos' => 'Monsalve Ramírez',
            'correo' => 'alejo@gmail.com',
            'imagen' => 'default.png',
            'usuario' => 'estudiante3',
            'password' => sha1("123"),
            'rol' => "estudiante",
            'activo' => 1
        );
        $this->db->insert('usuario', $data);


        $data = array(
            'id_usuario' => 6,
            'id_afiliacion' => 1,
            'nombres' => 'Jhon Alejandro',
            'apellidos' => 'Gómez',
            'correo' => 'alejo@gmail.com',
            'imagen' => 'default.png',
            'usuario' => 'estudiante4',
            'password' => sha1("123"),
            'rol' => "estudiante",
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 7,
            'id_afiliacion' => 1,
            'nombres' => 'Esteban',
            'apellidos' => 'Hoyos',
            'correo' => 'alejo@gmail.com',
            'imagen' => 'default.png',
            'usuario' => 'estudiante5',
            'password' => sha1("123"),
            'rol' => "estudiante",
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 8,
            'id_afiliacion' => 1,
            'nombres' => 'Andres Felipe',
            'apellidos' => 'Castaño',
            'correo' => 'alejo@gmail.com',
            'imagen' => 'default.png',
            'usuario' => 'estudiante6',
            'password' => sha1("123"),
            'rol' => "estudiante",
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 9,
            'id_afiliacion' => 1,
            'nombres' => 'Ricardo',
            'apellidos' => 'Cardona',
            'correo' => 'alejo@gmail.com',
            'imagen' => 'default.png',
            'usuario' => 'estudiante7',
            'password' => sha1("123"),
            'rol' => "estudiante",
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 10,
            'id_afiliacion' => 1,
            'nombres' => 'Manuel Fernando',
            'apellidos' => 'Betancur',
            'correo' => 'alejo@gmail.com',
            'imagen' => 'default.png',
            'usuario' => 'estudiante8',
            'password' => sha1("123"),
            'rol' => "estudiante",
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 11,
            'id_afiliacion' => 1,
            'nombres' => 'Oscar Alejandro',
            'apellidos' => 'Montoya Gómez',
            'correo' => 'alejo@gmail.com',
            'imagen' => 'default.png',
            'usuario' => 'estudiante9',
            'password' => sha1("123"),
            'rol' => "estudiante",
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 12,
            'id_afiliacion' => 1,
            'nombres' => 'Maria Soledad',
            'apellidos' => 'Ramirez Castaño',
            'correo' => 'alejo@gmail.com',
            'imagen' => 'default.png',
            'usuario' => 'estudiante10',
            'password' => sha1("123"),
            'rol' => "estudiante",
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 13,
            'id_afiliacion' => 1,
            'nombres' => 'Paola Andrea',
            'apellidos' => 'Vargas',
            'correo' => 'alejo@gmail.com',
            'imagen' => 'default.png',
            'usuario' => 'estudiante11',
            'password' => sha1("123"),
            'rol' => "estudiante",
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 14,
            'id_afiliacion' => 1,
            'nombres' => 'Vanessa ',
            'apellidos' => 'Molina',
            'correo' => 'alejo@gmail.com',
            'imagen' => 'default.png',
            'usuario' => 'estudiante12',
            'password' => sha1("123"),
            'rol' => "estudiante",
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 15,
            'id_afiliacion' => 1,
            'nombres' => 'Daniel Andres',
            'apellidos' => 'Gómez Ramírez',
            'correo' => 'alejo@gmail.com',
            'imagen' => 'default.png',
            'usuario' => 'estudiante13',
            'password' => sha1("123"),
            'rol' => "estudiante",
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 16,
            'id_afiliacion' => 1,
            'nombres' => 'Juan',
            'apellidos' => 'Escobar',
            'correo' => 'alejo@gmail.com',
            'imagen' => 'default.png',
            'usuario' => 'estudiante14',
            'password' => sha1("123"),
            'rol' => "estudiante",
            'activo' => 1
        );
        $this->db->insert('usuario', $data);
    }

    private function usuario_x_curso() {
        $this->db->empty_table('usuario_x_curso');
        $data = array(
            'id_curso' => 1,
            'id_usuario' => 1,
            'id_nivel' => 2,
            'fecha' => '2014-11-03 10:23:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 2,
            'fecha' => '2014-02-03 10:24:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 3,
            'fecha' => '2014-02-03 10:25:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 4,
            'fecha' => '2014-02-03 10:26:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 5,
            'fecha' => '2014-02-03 10:27:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 6,
            'fecha' => '2014-02-03 10:28:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 7,
            'fecha' => '2014-02-03 10:29:54'
        );
        $this->db->insert('usuario_x_curso', $data);
        $data = array(
            'id_curso' => 1,
            'id_usuario' => 8,
            'fecha' => '2014-02-03 10:30:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 9,
            'fecha' => '2014-02-03 10:32:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 10,
            'fecha' => '2014-02-03 10:34:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 11,
            'fecha' => '2014-05-03 10:42:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 12,
            'fecha' => '2014-06-03 10:52:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 13,
            'fecha' => '2014-07-03 10:52:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 14,
            'fecha' => '2014-08-03 10:52:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 15,
            'fecha' => '2014-09-03 10:52:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 16,
            'fecha' => '2014-10-03 10:52:54'
        );
        $this->db->insert('usuario_x_curso', $data);
    }

    private function modulo() {
        $this->db->empty_table('modulo');
        $data = array(
            'id_modulo' => 1,
            'id_curso' => 1,
            'nombre' => 'Integrales',
            'fecha_inicio' => '2014-01-07',
            'fecha_fin' => '2014-02-07',
            'descripcion' => 'La integración es un concepto fundamental del cálculo y del análisis matemático. Básicamente, una integral es una generalización de la suma de infinitos sumandos, infinitamente pequeños.'
        );
        $this->db->insert('modulo', $data);

        $data = array(
            'id_modulo' => 2,
            'id_curso' => 1,
            'nombre' => 'Aplicaciones de la integración',
            'fecha_inicio' => '2014-02-07',
            'fecha_fin' => '2014-03-07',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum. Mei facer fabulas ut, id eum stet regione.'
        );
        $this->db->insert('modulo', $data);

        $data = array(
            'id_modulo' => 3,
            'id_curso' => 1,
            'nombre' => 'Sucesiones y series infinitas',
            'fecha_inicio' => '2014-03-07',
            'fecha_fin' => '2014-04-07',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum. Mei facer fabulas ut, id eum stet regione.'
        );
        $this->db->insert('modulo', $data);

        $data = array(
            'id_modulo' => 4,
            'id_curso' => 1,
            'nombre' => 'Aplicaciones de la derivación',
            'fecha_inicio' => '2014-04-07',
            'fecha_fin' => '2014-05-07',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum. Mei facer fabulas ut, id eum stet regione.'
        );
        $this->db->insert('modulo', $data);
    }

    private function material() {
        $this->db->empty_table('material');
        $data = array(
            'id_material' => 1,
            'id_modulo' => 1,
            'nombre' => 'Operador sumatoria. Propiedades. Algunas sumatorias comunes. El problema del Área y el problema de la distancia.',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum. Mei facer fabulas ut, id eum stet regione.',
            'ubicacion' => '1.pdf',
            'orden' => 1
        );
        $this->db->insert('material', $data);

        $data = array(
            'id_material' => 2,
            'id_modulo' => 1,
            'nombre' => 'La integral definida: definición, evaluación de integrales utilizando Sumas de Riemann, propiedades de la integral definida',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum.',
            'ubicacion' => '2.mp4',
            'orden' => 2
        );
        $this->db->insert('material', $data);

        $data = array(
            'id_material' => 3,
            'id_modulo' => 1,
            'nombre' => 'Antiderivadas. Integrales indefinidas. Aplicaciones de las antiderivadas (movimiento rectilíneo).',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea.',
            'ubicacion' => '3.pdf',
            'orden' => 3
        );
        $this->db->insert('material', $data);

        $data = array(
            'id_material' => 4,
            'id_modulo' => 1,
            'nombre' => 'Evaluación de integrales definidas: Teorema de evaluación. Aplicaciones: Teorema de cambio total',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum.',
            'ubicacion' => '4.mp4',
            'orden' => 4
        );
        $this->db->insert('material', $data);
        $data = array(
            'id_modulo' => 1,
            'nombre' => 'Álgebra de funciones, composición de funciones',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum.',
            'ubicacion' => '2.mp4',
            'orden' => 5
        );
        $this->db->insert('material', $data);

        $data = array(
            'id_modulo' => 1,
            'nombre' => 'Funciones exponenciales: gráficas, leyes de los exponentes, modelación con funciones exponenciales, el número e',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum. Mei facer fabulas ut, id eum stet regione.',
            'ubicacion' => '1.pdf',
            'orden' => 6
        );
        $this->db->insert('material', $data);

        $data = array(
            'id_modulo' => 1,
            'nombre' => 'Función inversa: función uno a uno, prueba de la recta horizontal, definición de función inversa, gráfica de la función inversa',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum. Mei facer fabulas ut, id eum stet regione.',
            'ubicacion' => '2.mp4',
            'orden' => 7
        );
        $this->db->insert('material', $data);

        $data = array(
            'id_modulo' => 1,
            'nombre' => 'Funciones logarítmicas: definición, gráficas, leyes de los logaritmos, logaritmo natural, fórmula para el cambio de base, gráfica de la función logaritmo natural',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum. Mei facer fabulas ut, id eum stet regione.',
            'ubicacion' => '2.mp4',
            'orden' => 8
        );
        $this->db->insert('material', $data);

        $data = array(
            'id_modulo' => 1,
            'nombre' => 'Funciones trigonométricas inversas: función seno inverso, función tangente inversa, función coseno inverso',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum. Mei facer fabulas ut, id eum stet regione.',
            'ubicacion' => '1.pdf',
            'orden' => 9
        );
        $this->db->insert('material', $data);
    }

    private function tipo_evaluacion() {
        $this->db->empty_table('tipo_evaluacion');

        $data = array(
            'id_tipo_evaluacion' => 1,
            'nombre' => 'Selección multiple',
            'valor' => '250'
        );
        $this->db->insert('tipo_evaluacion', $data);

        $data = array(
            'id_tipo_evaluacion' => 2,
            'nombre' => 'Respuesta libre',
            'valor' => '350'
        );
        $this->db->insert('tipo_evaluacion', $data);

        $data = array(
            'id_tipo_evaluacion' => 3,
            'nombre' => 'Desafio',
            'valor' => '450'
        );
        $this->db->insert('tipo_evaluacion', $data);
    }

    private function evaluacion() {
        $this->db->empty_table('evaluacion');

        $data = array(
            'id_evaluacion' => 1,
            'id_modulo' => 1,
            'orden' => 1,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 2,
            'id_modulo' => 1,
            'orden' => 2,
            'id_tipo_evaluacion' => 2
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 3,
            'id_modulo' => 1,
            'orden' => 3,
            'id_tipo_evaluacion' => 3
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 4,
            'id_modulo' => 1,
            'orden' => 4,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);
    }

    private function usuario_x_evaluacion() {
        $this->db->empty_table('usuario_x_evaluacion');
        $data = array(
            'id_usuario_evaluacion' => 1,
            'id_usuario' => 1,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-03-05 12:14:44',
            'fecha_final' => '2014-03-05 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);

        $data = array(
            'id_usuario_evaluacion' => 2,
            'id_usuario' => 2,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-03-05 12:14:44',
            'fecha_final' => '2014-03-05 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);

        $data = array(
            'id_usuario_evaluacion' => 3,
            'id_usuario' => 4,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-03-05 12:14:44',
            'fecha_final' => '2014-03-05 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);

        $data = array(
            'id_usuario_evaluacion' => 4,
            'id_usuario' => 5,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-03-05 12:14:44',
            'fecha_final' => '2014-03-05 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);

        $data = array(
            'id_usuario_evaluacion' => 5,
            'id_usuario' => 6,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-03-05 12:14:44',
            'fecha_final' => '2014-03-05 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);

        $data = array(
            'id_usuario_evaluacion' => 6,
            'id_usuario' => 7,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-03-05 12:14:44',
            'fecha_final' => '2014-03-05 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);

        $data = array(
            'id_usuario_evaluacion' => 7,
            'id_usuario' => 8,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-03-05 12:14:44',
            'fecha_final' => '2014-03-05 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);

        $data = array(
            'id_usuario_evaluacion' => 8,
            'id_usuario' => 9,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-03-05 12:14:44',
            'fecha_final' => '2014-03-05 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);

        $data = array(
            'id_usuario_evaluacion' => 9,
            'id_usuario' => 10,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-03-05 12:14:44',
            'fecha_final' => '2014-03-05 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);

        $data = array(
            'id_usuario_evaluacion' => 10,
            'id_usuario' => 11,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-03-05 12:14:44',
            'fecha_final' => '2014-03-05 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);

        $data = array(
            'id_usuario_evaluacion' => 11,
            'id_usuario' => 12,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-03-05 12:14:44',
            'fecha_final' => '2014-03-05 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);

        $data = array(
            'id_usuario_evaluacion' => 12,
            'id_usuario' => 14,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-03-05 12:14:44',
            'fecha_final' => '2014-03-05 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);

        $data = array(
            'id_usuario_evaluacion' => 13,
            'id_usuario' => 15,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-03-05 12:14:44',
            'fecha_final' => '2014-03-05 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);

        $data = array(
            'id_usuario_evaluacion' => 14,
            'id_usuario' => 16,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-03-05 12:14:44',
            'fecha_final' => '2014-03-05 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);
    }

    private function usuario_x_modulo() {
        $this->db->empty_table('usuario_x_modulo');
        $data = array(
            'id_usuario_modulo' => 1,
            'id_usuario' => 1,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);

        $data = array(
            'id_usuario_modulo' => 2,
            'id_usuario' => 2,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);

        $data = array(
            'id_usuario_modulo' => 3,
            'id_usuario' => 4,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);

        $data = array(
            'id_usuario_modulo' => 4,
            'id_usuario' => 5,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);
        $data = array(
            'id_usuario_modulo' => 5,
            'id_usuario' => 6,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);
        $data = array(
            'id_usuario_modulo' => 6,
            'id_usuario' => 7,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);
        $data = array(
            'id_usuario_modulo' => 7,
            'id_usuario' => 8,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);
        $data = array(
            'id_usuario_modulo' => 8,
            'id_usuario' => 9,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);
        $data = array(
            'id_usuario_modulo' => 9,
            'id_usuario' => 10,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);

        $data = array(
            'id_usuario_modulo' => 10,
            'id_usuario' => 11,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);

        $data = array(
            'id_usuario_modulo' => 11,
            'id_usuario' => 12,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);

        $data = array(
            'id_usuario_modulo' => 12,
            'id_usuario' => 14,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);

        $data = array(
            'id_usuario_modulo' => 13,
            'id_usuario' => 15,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);

        $data = array(
            'id_usuario_modulo' => 14,
            'id_usuario' => 16,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);
    }

    private function tema_foro() {
        $this->db->empty_table('tema_foro');
        $data = array(
            'id_tema_foro' => 1,
            'id_curso' => 1,
            'id_usuario' => 2,
            'nombre' => 'Lorem ipsum dolor sit amet, vitae ullamcorper praesent, convallis justo interdum.',
            'descripcion' => 'Lorem ipsum dolor sit amet, vitae ullamcorper praesent, convallis justo interdum eget arcu in nulla. Dapibus amet rhoncus risus ornare, rhoncus vitae ut mollis blandit. Distinctio a, dolor dolor suspendisse eu in. Mauris aenean in, fusce donec diam sapien aenean cum nunc, interdum urna, egestas nunc diam, lacus ante et hac nulla. Interdum morbi iaculis aliquam elit habitant blandit, neque necessitatibus eu fringilla metus blandit. Lacus lacus dictum urna amet nibh, ante donec ipsum posuere. Quisque morbi porta elit quis, quis tortor ante lacinia donec nunc commodo, ullamcorper massa enim morbi porttitor. Arcu urna vel. Amet ut placerat velit laoreet in dui, gravida qui lorem, convallis magna mi nec dapibus risus curabitur, natoque sed. Praesent enim facilisis sociis metus congue, lacus ultricies morbi bibendum, lorem egestas sodales sint.',
            'fecha_creacion' => '2014-03-05 11:15:50',
        );
        $this->db->insert('tema_foro', $data);

        $data = array(
            'id_tema_foro' => 2,
            'id_curso' => 1,
            'id_usuario' => 2,
            'nombre' => 'Lorem ipsum dolor sit amet, vitae ullamcorper praesent, convallis justo interdum.',
            'descripcion' => 'Lorem ipsum dolor sit amet, vitae ullamcorper praesent, convallis justo interdum eget arcu in nulla. Dapibus amet rhoncus risus ornare, rhoncus vitae ut mollis blandit. Distinctio a, dolor dolor suspendisse eu in. Mauris aenean in, fusce donec diam sapien aenean cum nunc, interdum urna, egestas nunc diam, lacus ante et hac nulla. Interdum morbi iaculis aliquam elit habitant blandit, neque necessitatibus eu fringilla metus blandit. Lacus lacus dictum urna amet nibh, ante donec ipsum posuere. Quisque morbi porta elit quis, quis tortor ante lacinia donec nunc commodo, ullamcorper massa enim morbi porttitor. Arcu urna vel. Amet ut placerat velit laoreet in dui, gravida qui lorem, convallis magna mi nec dapibus risus curabitur, natoque sed. Praesent enim facilisis sociis metus congue, lacus ultricies morbi bibendum, lorem egestas sodales sint.',
            'fecha_creacion' => '2014-03-05 13:15:50',
        );
        $this->db->insert('tema_foro', $data);

        $data = array(
            'id_tema_foro' => 3,
            'id_curso' => 1,
            'id_usuario' => 3,
            'nombre' => 'Lorem ipsum dolor sit amet, vitae ullamcorper praesent, convallis justo interdum.',
            'descripcion' => 'Lorem ipsum dolor sit amet, vitae ullamcorper praesent, convallis justo interdum eget arcu in nulla. Dapibus amet rhoncus risus ornare, rhoncus vitae ut mollis blandit. Distinctio a, dolor dolor suspendisse eu in. Mauris aenean in, fusce donec diam sapien aenean cum nunc, interdum urna, egestas nunc diam, lacus ante et hac nulla. Interdum morbi iaculis aliquam elit habitant blandit, neque necessitatibus eu fringilla metus blandit. Lacus lacus dictum urna amet nibh, ante donec ipsum posuere. Quisque morbi porta elit quis, quis tortor ante lacinia donec nunc commodo, ullamcorper massa enim morbi porttitor. Arcu urna vel. Amet ut placerat velit laoreet in dui, gravida qui lorem, convallis magna mi nec dapibus risus curabitur, natoque sed. Praesent enim facilisis sociis metus congue, lacus ultricies morbi bibendum, lorem egestas sodales sint.',
            'fecha_creacion' => '2014-03-05 13:15:50',
        );
        $this->db->insert('tema_foro', $data);
        $data = array(
            'id_tema_foro' => 4,
            'id_curso' => 1,
            'id_usuario' => 2,
            'nombre' => 'Lorem ipsum dolor sit amet, vitae ullamcorper praesent, convallis justo interdum.',
            'descripcion' => 'Lorem ipsum dolor sit amet, vitae ullamcorper praesent, convallis justo interdum eget arcu in nulla. Dapibus amet rhoncus risus ornare, rhoncus vitae ut mollis blandit. Distinctio a, dolor dolor suspendisse eu in. Mauris aenean in, fusce donec diam sapien aenean cum nunc, interdum urna, egestas nunc diam, lacus ante et hac nulla. Interdum morbi iaculis aliquam elit habitant blandit, neque necessitatibus eu fringilla metus blandit. Lacus lacus dictum urna amet nibh, ante donec ipsum posuere. Quisque morbi porta elit quis, quis tortor ante lacinia donec nunc commodo, ullamcorper massa enim morbi porttitor. Arcu urna vel. Amet ut placerat velit laoreet in dui, gravida qui lorem, convallis magna mi nec dapibus risus curabitur, natoque sed. Praesent enim facilisis sociis metus congue, lacus ultricies morbi bibendum, lorem egestas sodales sint.',
            'fecha_creacion' => '2014-03-05 13:15:50',
        );
        $this->db->insert('tema_foro', $data);
        $data = array(
            'id_tema_foro' => 5,
            'id_curso' => 1,
            'id_usuario' => 2,
            'nombre' => 'Lorem ipsum dolor sit amet, vitae ullamcorper praesent, convallis justo interdum.',
            'descripcion' => 'Lorem ipsum dolor sit amet, vitae ullamcorper praesent, convallis justo interdum eget arcu in nulla. Dapibus amet rhoncus risus ornare, rhoncus vitae ut mollis blandit. Distinctio a, dolor dolor suspendisse eu in. Mauris aenean in, fusce donec diam sapien aenean cum nunc, interdum urna, egestas nunc diam, lacus ante et hac nulla. Interdum morbi iaculis aliquam elit habitant blandit, neque necessitatibus eu fringilla metus blandit. Lacus lacus dictum urna amet nibh, ante donec ipsum posuere. Quisque morbi porta elit quis, quis tortor ante lacinia donec nunc commodo, ullamcorper massa enim morbi porttitor. Arcu urna vel. Amet ut placerat velit laoreet in dui, gravida qui lorem, convallis magna mi nec dapibus risus curabitur, natoque sed. Praesent enim facilisis sociis metus congue, lacus ultricies morbi bibendum, lorem egestas sodales sint.',
            'fecha_creacion' => '2014-03-05 13:15:50',
        );
        $this->db->insert('tema_foro', $data);
    }

    private function respuesta() {
        $this->db->empty_table('respuesta');
        $data = array(
            'id_respuesta' => 1,
            'id_tema_foro' => 1,
            'id_usuario' => 4,
            'respuesta' => 'Lorem ipsum dolor sit amet, vitae ullamcorper praesent, convallis justo interdum eget arcu in nulla. Dapibus amet rhoncus risus ornare, rhoncus vitae ut mollis blandit. Distinctio a, dolor dolor suspendisse eu in. Mauris aenean in, fusce donec diam sapien aenean cum nunc, interdum urna, egestas nunc diam, lacus ante et hac nulla. Interdum morbi iaculis aliquam elit habitant blandit, neque necessitatibus eu fringilla metus blandit. Lacus lacus dictum urna amet nibh, ante donec ipsum posuere. Quisque morbi porta elit quis, quis tortor ante lacinia donec nunc commodo, ullamcorper massa enim morbi porttitor. Arcu urna vel. Amet ut placerat velit laoreet in dui, gravida qui lorem, convallis magna mi nec dapibus risus curabitur, natoque sed. Praesent enim facilisis sociis metus congue, lacus ultricies morbi bibendum, lorem egestas sodales sint.',
            'fecha_creacion' => '2014-03-05 11:15:50',
        );
        $this->db->insert('respuesta', $data);

        $data = array(
            'id_respuesta' => 2,
            'id_tema_foro' => 1,
            'id_usuario' => 5,
            'respuesta' => 'Lorem ipsum dolor sit amet, vitae ullamcorper praesent, convallis justo interdum eget arcu in nulla. Dapibus amet rhoncus risus ornare, rhoncus vitae ut mollis blandit. Distinctio a, dolor dolor suspendisse eu in. Mauris aenean in, fusce donec diam sapien aenean cum nunc, interdum urna, egestas nunc diam, lacus ante et hac nulla. Interdum morbi iaculis aliquam elit habitant blandit, neque necessitatibus eu fringilla metus blandit. Lacus lacus dictum urna amet nibh, ante donec ipsum posuere. Quisque morbi porta elit quis, quis tortor ante lacinia donec nunc commodo, ullamcorper massa enim morbi porttitor. Arcu urna vel. Amet ut placerat velit laoreet in dui, gravida qui lorem, convallis magna mi nec dapibus risus curabitur, natoque sed. Praesent enim facilisis sociis metus congue, lacus ultricies morbi bibendum, lorem egestas sodales sint.',
            'fecha_creacion' => '2014-03-05 11:15:50',
        );
        $this->db->insert('respuesta', $data);
        $data = array(
            'id_respuesta' => 3,
            'id_tema_foro' => 1,
            'id_usuario' => 6,
            'respuesta' => 'Lorem ipsum dolor sit amet, vitae ullamcorper praesent, convallis justo interdum eget arcu in nulla. Dapibus amet rhoncus risus ornare, rhoncus vitae ut mollis blandit. Distinctio a, dolor dolor suspendisse eu in. Mauris aenean in, fusce donec diam sapien aenean cum nunc, interdum urna, egestas nunc diam, lacus ante et hac nulla. Interdum morbi iaculis aliquam elit habitant blandit, neque necessitatibus eu fringilla metus blandit. Lacus lacus dictum urna amet nibh, ante donec ipsum posuere. Quisque morbi porta elit quis, quis tortor ante lacinia donec nunc commodo, ullamcorper massa enim morbi porttitor. Arcu urna vel. Amet ut placerat velit laoreet in dui, gravida qui lorem, convallis magna mi nec dapibus risus curabitur, natoque sed. Praesent enim facilisis sociis metus congue, lacus ultricies morbi bibendum, lorem egestas sodales sint.',
            'fecha_creacion' => '2014-03-05 11:15:50',
        );
        $this->db->insert('respuesta', $data);
        $data = array(
            'id_respuesta' => 4,
            'id_tema_foro' => 1,
            'id_usuario' => 7,
            'respuesta' => 'Lorem ipsum dolor sit amet, vitae ullamcorper praesent, convallis justo interdum eget arcu in nulla. Dapibus amet rhoncus risus ornare, rhoncus vitae ut mollis blandit. Distinctio a, dolor dolor suspendisse eu in. Mauris aenean in, fusce donec diam sapien aenean cum nunc, interdum urna, egestas nunc diam, lacus ante et hac nulla. Interdum morbi iaculis aliquam elit habitant blandit, neque necessitatibus eu fringilla metus blandit. Lacus lacus dictum urna amet nibh, ante donec ipsum posuere. Quisque morbi porta elit quis, quis tortor ante lacinia donec nunc commodo, ullamcorper massa enim morbi porttitor. Arcu urna vel. Amet ut placerat velit laoreet in dui, gravida qui lorem, convallis magna mi nec dapibus risus curabitur, natoque sed. Praesent enim facilisis sociis metus congue, lacus ultricies morbi bibendum, lorem egestas sodales sint.',
            'fecha_creacion' => '2014-03-05 11:15:50',
        );
        $this->db->insert('respuesta', $data);
        $data = array(
            'id_respuesta' => 5,
            'id_tema_foro' => 1,
            'id_usuario' => 8,
            'respuesta' => 'Lorem ipsum dolor sit amet, vitae ullamcorper praesent, convallis justo interdum eget arcu in nulla. Dapibus amet rhoncus risus ornare, rhoncus vitae ut mollis blandit. Distinctio a, dolor dolor suspendisse eu in. Mauris aenean in, fusce donec diam sapien aenean cum nunc, interdum urna, egestas nunc diam, lacus ante et hac nulla. Interdum morbi iaculis aliquam elit habitant blandit, neque necessitatibus eu fringilla metus blandit. Lacus lacus dictum urna amet nibh, ante donec ipsum posuere. Quisque morbi porta elit quis, quis tortor ante lacinia donec nunc commodo, ullamcorper massa enim morbi porttitor. Arcu urna vel. Amet ut placerat velit laoreet in dui, gravida qui lorem, convallis magna mi nec dapibus risus curabitur, natoque sed. Praesent enim facilisis sociis metus congue, lacus ultricies morbi bibendum, lorem egestas sodales sint.',
            'fecha_creacion' => '2014-03-05 11:15:50',
        );
        $this->db->insert('respuesta', $data);
    }

    private function logro() {
        $this->db->empty_table('logro');
        $data = array(
            'id_logro' => 1,
            'nombre' => 'Primer ejercicio',
            'descripcion' => 'Se gana cuando se soluciona el primer ejercicio.'
        );
        $this->db->insert('logro', $data);

        $data = array(
            'id_logro' => 2,
            'nombre' => '25%',
            'descripcion' => 'Se gana cuando se completa el 25% del curso'
        );
        $this->db->insert('logro', $data);

        $data = array(
            'id_logro' => 3,
            'nombre' => '50%',
            'descripcion' => 'Se gana cuando se completa el 50% del curso.'
        );
        $this->db->insert('logro', $data);

        $data = array(
            'id_logro' => 4,
            'nombre' => '75%',
            'descripcion' => 'Se gana cuando se completa el 75% del curso'
        );
        $this->db->insert('logro', $data);

        $data = array(
            'id_logro' => 5,
            'nombre' => '100%',
            'descripcion' => 'Se gana cuando se completa el 100% del curso'
        );
        $this->db->insert('logro', $data);

        $data = array(
            'id_logro' => 6,
            'nombre' => 'Mi primera participación en foro',
            'descripcion' => 'Se gana cuando se participa por primera vez en el foro'
        );
        $this->db->insert('logro', $data);

        $data = array(
            'id_logro' => 7,
            'nombre' => 'Tema popular',
            'descripcion' => 'Se gana cuando un tema que creaste tiene mas de 5 entradas'
        );
        $this->db->insert('logro', $data);

        $data = array(
            'id_logro' => 8,
            'nombre' => 'Tema Superpopular',
            'descripcion' => 'Se gana cuando un tema que creaste tiene mas de 20 entradas'
        );
        $this->db->insert('logro', $data);

        $data = array(
            'id_logro' => 9,
            'nombre' => 'Muy participativo',
            'descripcion' => 'Se gana cuando un usuario escribe 5 entradas en el foro.'
        );
        $this->db->insert('logro', $data);

        $data = array(
            'id_logro' => 10,
            'nombre' => 'Superparticipativo',
            'descripcion' => 'Se gana cuando un usuario escribe 20 entradas en el foro.'
        );
        $this->db->insert('logro', $data);
        $data = array(
            'id_logro' => 11,
            'nombre' => '3 en línea',
            'descripcion' => 'Se gana cuando se resuelven 3 ejercicios consecutivos.'
        );
        $this->db->insert('logro', $data);
        $data = array(
            'id_logro' => 12,
            'nombre' => '5 en línea',
            'descripcion' => 'Se gana cuando se resuelven 5 ejercicios consecutivos.'
        );
        $this->db->insert('logro', $data);
        $data = array(
            'id_logro' => 13,
            'nombre' => '10 en línea',
            'descripcion' => 'Se gana cuando se resuelven 10 ejercicios consecutivos.'
        );
        $this->db->insert('logro', $data);
    }

    private function usuario_curso_logro() {
        $this->db->empty_table('usuario_curso_logro');
        $data = array(
            'id_usuario_curso_logro' => 1,
            'id_usuario' => 1,
            'id_curso' => 1,
            'id_logro' => 1,
            'visto' => 1
        );
        $this->db->insert('usuario_curso_logro', $data);

        $data = array(
            'id_usuario_curso_logro' => 2,
            'id_usuario' => 1,
            'id_curso' => 1,
            'id_logro' => 2,
            'visto' => 1
        );
        $this->db->insert('usuario_curso_logro', $data);
    }

    private function muro() {
        $this->db->empty_table('muro');
        $data = array(
            'id_muro' => 1,
            'id_curso' => 1,
            'id_usuario' => 1,
            'mensaje' => 1,
            'tipo' => 'logro'
        );
        $this->db->insert('muro', $data);

        $data = array(
            'id_muro' => 2,
            'muro_id_muro' => 1,
            'id_curso' => 1,
            'id_usuario' => 10,
            'mensaje' => "Felicitaciones!"
        );
        $this->db->insert('muro', $data);
    }

}
