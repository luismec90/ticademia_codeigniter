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
//        $this->material();
        $this->tipo_evaluacion();
        $this->evaluacion();
//        $this->usuario_x_evaluacion();
//        $this->usuario_x_modulo();
        $this->tema_foro();
        $this->muro();
        /*
          $this->usuario_x_material();


          $this->respuesta(); */
        $this->logro();
        /*      $this->usuario_curso_logro();

          $this->bitacora_nivel();
          $this->bitacora(); */
//        $this->evaluacion_x_material();
    }

    private function asignatura() {
        $this->db->empty_table('asignatura');
        $data = array(
            'id_asignatura' => 1,
            'nombre' => 'Matemáticas básicas',
            'descripcion' => 'Este curso tiene como objetivo ofrecer al alumno recién admitido, y con una formación matemática deficiente, la oportunidad de nivelarse en temas que forman parte de los programas oficiales de la educación secundaria en matemáticas y cuyo conocimiento es pre-requisito esencial para asignaturas como Cálculo Diferencial.',
            'tabla_contenido' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum. Mei facer fabulas ut, id eum stet regione. An posse albucius invidunt qui, nam mundi ceteros vulputate et. Ex unum reprehendunt his. Eam accusata mnesarchum an, eu his doming accusata. Et est consulatu assueverit, sit ancillae suavitate te. Ex omnium timeam indoctum vix, in viris deleniti eum, has discere recteque persequeris eu. Eum ne solet oblique tincidunt. Movet latine iuvaret eos ut, dicit regione in mei. Ea tibique corpora atomorum vel, dicant detracto intellegat vel et, graeco aliquid propriae ea ius. Odio paulo reprimique vix ex. Usu habemus dolores tacimates ex, ad aliquip fastidii sea, saepe forensibus ex duo. Has ullum causae dissentiet no, cum nostrud voluptatibus cu. Justo possit minimum duo cu, sea eu dolorum intellegat. Noster repudiare mea ut, cu ius appareat rationibus. Nec aliquip mediocrem ut, ius alterum concludaturque te. Vix no melius suavitate. Te facilis percipitur nec, minim forensibus mei eu. Te has maiorum percipitur. Pro bonorum detracto repudiandae at. Vim ferri eruditi appellantur an. Nam utinam eligendi lucilius ea, ad sea agam probatus. Ius homero commune id, te eam agam accusata.',
            'idioma' => 'Español',
            'prerequisitos' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum. Mei facer fabulas ut, id eum stet regione. An posse albucius invidunt qui, nam mundi ceteros vulputate et. Ex unum reprehendunt his. Eam accusata mnesarchum an, eu his doming accusata. Et est consulatu assueverit, sit ancillae suavitate te. Ex omnium timeam indoctum vix, in viris deleniti eum, has discere recteque persequeris eu. Eum ne solet oblique tincidunt. Movet latine iuvaret eos ut, dicit regione in mei. Ea tibique corpora atomorum vel, dicant detracto intellegat vel et, graeco aliquid propriae ea ius. Odio paulo reprimique vix ex. Usu habemus dolores tacimates ex, ad aliquip fastidii sea, saepe forensibus ex duo. Has ullum causae dissentiet no, cum nostrud voluptatibus cu. Justo possit minimum duo cu, sea eu dolorum intellegat. Noster repudiare mea ut, cu ius appareat rationibus. Nec aliquip mediocrem ut, ius alterum concludaturque te. Vix no melius suavitate. Te facilis percipitur nec, minim forensibus mei eu. Te has maiorum percipitur. Pro bonorum detracto repudiandae at. Vim ferri eruditi appellantur an. Nam utinam eligendi lucilius ea, ad sea agam probatus. Ius homero commune id, te eam agam accusata.'
        );
        $this->db->insert('asignatura', $data);
      
        $data = array(
            'id_asignatura' => 2,
            'nombre' => 'Análisis de fallas en líneas de transmisión',
            'descripcion' => 'Descripción....	',
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
            'nombre' => 'Zombie',
            'imagen' => '1.png',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea'
        );
        $this->db->insert('nivel', $data);

        $data = array(
            'id_nivel' => 2,
            'nombre' => 'Principiante',
            'imagen' => '2.png',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea'
        );
        $this->db->insert('nivel', $data);

        $data = array(
            'id_nivel' => 3,
            'nombre' => 'Pupilo',
            'imagen' => '3.png',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea'
        );
        $this->db->insert('nivel', $data);

        $data = array(
            'id_nivel' => 4,
            'nombre' => 'Aprendiz',
            'imagen' => '4.png',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea'
        );
        $this->db->insert('nivel', $data);

        $data = array(
            'id_nivel' => 5,
            'nombre' => 'Iniciado',
            'imagen' => '5.png',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea'
        );
        $this->db->insert('nivel', $data);

        $data = array(
            'id_nivel' => 6,
            'nombre' => 'Conocedor',
            'imagen' => '6.png',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea'
        );
        $this->db->insert('nivel', $data);

        $data = array(
            'id_nivel' => 7,
            'nombre' => 'Maestro',
            'imagen' => '7.png',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea'
        );
        $this->db->insert('nivel', $data);

        $data = array(
            'id_nivel' => 8,
            'nombre' => 'Sabio',
            'imagen' => '8.png',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea'
        );
        $this->db->insert('nivel', $data);

        $data = array(
            'id_nivel' => 9,
            'nombre' => 'Erudito',
            'imagen' => '9.png',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea'
        );
        $this->db->insert('nivel', $data);

        $data = array(
            'id_nivel' => 10,
            'nombre' => 'Dios de la Sapiensa',
            'imagen' => '10.png',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea'
        );
        $this->db->insert('nivel', $data);
    }

    private function curso() {
        $this->db->empty_table('curso');
        $data = array(
            'id_curso' => 1,
            'id_asignatura' => 1,
            'fecha_inicio' => '2014-06-26',
            'niveles' => '5',
            'fecha_fin' => '2014-05-07',
            'umbral' => 0.6
        );
        $this->db->insert('curso', $data);

        $data = array(
            'id_curso' => 2,
            'id_asignatura' => 2,
            'fecha_inicio' => '2014-06-30',
            'niveles' => '5',
            'fecha_fin' => '2014-09-07',
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
            'correo' => 'estudiante1',
            'imagen' => '1.jpg',
            'sexo' => 'm',
            'password' => sha1("123"),
            'fecha_nacimiento' => date("Y-m-d"),
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 2,
            'id_afiliacion' => 1,
            'nombres' => 'Julian',
            'apellidos' => 'Moreno Cadavid',
            'correo' => 'profesor1',
            'imagen' => 'default.png',
            'sexo' => 'm',
            'password' => sha1("123"),
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 3,
            'id_afiliacion' => 1,
            'nombres' => 'Francisco Javier',
            'apellidos' => 'Moreno',
            'correo' => 'profesor2',
            'imagen' => 'default.png',
            'sexo' => 'm',
            'password' => sha1("123"),
            'activo' => 1
        );
        $this->db->insert('usuario', $data);


        $data = array(
            'id_usuario' => 4,
            'id_afiliacion' => 1,
            'nombres' => 'Roger A',
            'apellidos' => 'Cadavid',
            'correo' => 'estudiante2',
            'imagen' => 'default.png',
            'sexo' => 'm',
            'password' => sha1("123"),
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 5,
            'id_afiliacion' => 1,
            'nombres' => 'Juan Camilo',
            'apellidos' => 'Monsalve Ramírez',
            'correo' => 'monitor1',
            'imagen' => 'default.png',
            'sexo' => 'm',
            'password' => sha1("123"),
            'activo' => 1
        );
        $this->db->insert('usuario', $data);


        $data = array(
            'id_usuario' => 6,
            'id_afiliacion' => 1,
            'nombres' => 'Jhon Alejandro',
            'apellidos' => 'Gómez',
            'correo' => 'estudiante3',
            'imagen' => 'default.png',
            'sexo' => 'm',
            'password' => sha1("123"),
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 7,
            'id_afiliacion' => 1,
            'nombres' => 'Esteban',
            'apellidos' => 'Hoyos',
            'correo' => 'estudiante4',
            'imagen' => 'default.png',
            'sexo' => 'm',
            'password' => sha1("123"),
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 8,
            'id_afiliacion' => 1,
            'nombres' => 'Andres Felipe',
            'apellidos' => 'Castaño',
            'correo' => 'estudiante5',
            'imagen' => 'default.png',
            'sexo' => 'm',
            'password' => sha1("123"),
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 9,
            'id_afiliacion' => 1,
            'nombres' => 'Ricardo',
            'apellidos' => 'Cardona',
            'correo' => 'estudiante6',
            'imagen' => 'default.png',
            'sexo' => 'm',
            'password' => sha1("123"),
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 10,
            'id_afiliacion' => 1,
            'nombres' => 'Manuel Fernando',
            'apellidos' => 'Betancur',
            'correo' => 'estudiante7',
            'imagen' => 'default.png',
            'sexo' => 'm',
            'password' => sha1("123"),
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 11,
            'id_afiliacion' => 1,
            'nombres' => 'Oscar Alejandro',
            'apellidos' => 'Montoya Gómez',
            'correo' => 'estudiante8',
            'imagen' => 'default.png',
            'sexo' => 'm',
            'password' => sha1("123"),
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 12,
            'id_afiliacion' => 1,
            'nombres' => 'Maria Soledad',
            'apellidos' => 'Ramirez Castaño',
            'correo' => 'estudiante9',
            'imagen' => 'default.png',
            'sexo' => 'm',
            'password' => sha1("123"),
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 13,
            'id_afiliacion' => 1,
            'nombres' => 'Paola Andrea',
            'apellidos' => 'Vargas',
            'correo' => 'estudiante10',
            'imagen' => 'default.png',
            'sexo' => 'm',
            'password' => sha1("123"),
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 14,
            'id_afiliacion' => 1,
            'nombres' => 'Vanessa ',
            'apellidos' => 'Molina',
            'correo' => 'estudiante11',
            'imagen' => 'default.png',
            'sexo' => 'm',
            'password' => sha1("123"),
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 15,
            'id_afiliacion' => 1,
            'nombres' => 'Daniela',
            'apellidos' => 'Gómez Ramírez',
            'correo' => 'estudiante12',
            'imagen' => 'default.png',
            'sexo' => 'f',
            'password' => sha1("123"),
            'activo' => 1
        );
        $this->db->insert('usuario', $data);

        $data = array(
            'id_usuario' => 16,
            'id_afiliacion' => 1,
            'nombres' => 'Juan',
            'apellidos' => 'Escobar',
            'correo' => 'monitor1',
            'imagen' => 'default.png',
            'sexo' => 'm',
            'password' => sha1("123"),
            'activo' => 1
        );
        $this->db->insert('usuario', $data);
    }

    private function usuario_x_curso() {
        $this->db->empty_table('usuario_x_curso');
        $data = array(
            'id_curso' => 1,
            'id_usuario' => 1,
            'rol' => 1,
            'fecha' => '2014-11-03 10:23:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 2,
            'rol' => 2,
            'fecha' => '2014-02-03 10:24:54'
        );
        $this->db->insert('usuario_x_curso', $data);


        $data = array(
            'id_curso' => 1,
            'id_usuario' => 3,
            'rol' => 2,
            'fecha' => '2014-02-03 10:25:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 4,
            'rol' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-02-03 10:26:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 5,
            'rol' => 3,
            'fecha' => '2014-02-03 10:27:54',
            'informacion_contacto' => 'Luner Martes Miecoles 6-8 pm skype: qwee32'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 6,
            'rol' => 1,
            'id_nivel' => 3,
            'fecha' => '2014-02-03 10:28:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 7,
            'rol' => 1,
            'id_nivel' => 4,
            'fecha' => '2014-02-03 10:29:54'
        );
        $this->db->insert('usuario_x_curso', $data);
        $data = array(
            'id_curso' => 1,
            'id_usuario' => 8,
            'rol' => 1,
            'id_nivel' => 4,
            'fecha' => '2014-02-03 10:30:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 9,
            'rol' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-02-03 10:32:54'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 10,
            'rol' => 1,
            'fecha' => '2014-02-03 10:34:54',
            'informacion_contacto' => 'Luner Martes Miecoles 6-8 pm skype: qwee32'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 11,
            'rol' => 1,
            'fecha' => '2014-05-03 10:42:54',
            'informacion_contacto' => 'Luner Martes Miecoles 6-8 pm skype: qwee32'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 12,
            'rol' => 1,
            'fecha' => '2014-06-03 10:52:54',
            'informacion_contacto' => 'Luner Martes Miecoles 6-8 pm skype: qwee32'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 13,
            'rol' => 1,
            'fecha' => '2014-07-03 10:52:54',
            'informacion_contacto' => 'Luner Martes Miecoles 6-8 pm skype: qwee32'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 14,
            'rol' => 1,
            'fecha' => '2014-08-03 10:52:54',
            'informacion_contacto' => 'Luner Martes Miecoles 6-8 pm skype: qwee32'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 15,
            'rol' => 1,
            'fecha' => '2014-09-03 10:52:54',
            'informacion_contacto' => 'Luner Martes Miecoles 6-8 pm skype: qwee32'
        );
        $this->db->insert('usuario_x_curso', $data);

        $data = array(
            'id_curso' => 1,
            'id_usuario' => 16,
            'rol' => 3,
            'fecha' => '2014-10-03 10:52:54',
            'informacion_contacto' => 'Luner Martes Miecoles 6-8 pm skype: qwee32'
        );
        $this->db->insert('usuario_x_curso', $data);
    }

    private function modulo() {
        $this->db->empty_table('modulo');
        $data = array(
            'id_modulo' => 1,
            'id_curso' => 1,
            'nombre' => 'Geometría elemental, conjuntos y sistemas numéricos',
            'fecha_inicio' => '2014-08-04',
            'fecha_fin' => '2014-08-20',
            'descripcion' => 'Descripción...'
        );
        $this->db->insert('modulo', $data);

        $data = array(
            'id_modulo' => 2,
            'id_curso' => 1,
            'nombre' => 'Álgebra',
            'fecha_inicio' => '2014-08-21',
            'fecha_fin' => '2014-09-14',
            'descripcion' => 'Descripción...'
        );
        $this->db->insert('modulo', $data);

        $data = array(
            'id_modulo' => 3,
            'id_curso' => 1,
            'nombre' => 'Ecuaciones y desigualdades',
            'fecha_inicio' => '2014-09-15',
            'fecha_fin' => '2014-09-28',
            'descripcion' => 'Descripción...'
        );
        $this->db->insert('modulo', $data);

        $data = array(
            'id_modulo' => 4,
            'id_curso' => 1,
            'nombre' => 'Funciones reales',
            'fecha_inicio' => '2014-09-29',
            'fecha_fin' => '2014-10-29',
            'descripcion' => 'Descripción...'
        );
        $this->db->insert('modulo', $data);

        $data = array(
            'id_modulo' => 5,
            'id_curso' => 1,
            'nombre' => 'Trigonometría',
            'fecha_inicio' => '2014-10-30',
            'fecha_fin' => '2014-11-19',
            'descripcion' => 'Descripción...'
        );
        $this->db->insert('modulo', $data);

        $data = array(
            'id_modulo' => 6,
            'id_curso' => 2,
            'nombre' => 'Introducción al análisis de fallas en sistemas de potencia',
            'fecha_inicio' => '2014-06-30',
            'fecha_fin' => '2014-07-13',
            'descripcion' => 'Descripción...'
        );
        $this->db->insert('modulo', $data);

        $data = array(
            'id_modulo' => 7,
            'id_curso' => 2,
            'nombre' => 'Generalidades del análisis de fallas en líneas de transmisión',
            'fecha_inicio' => '2014-07-14',
            'fecha_fin' => '2014-07-27',
            'descripcion' => 'Descripción...'
        );
        $this->db->insert('modulo', $data);

        $data = array(
            'id_modulo' => 8,
            'id_curso' => 2,
            'nombre' => 'Fenómenos relacionados con las fallas en líneas de transmisión',
            'fecha_inicio' => '2014-07-28',
            'fecha_fin' => '2014-08-10',
            'descripcion' => 'Descripción...'
        );
        $this->db->insert('modulo', $data);

        $data = array(
            'id_modulo' => 9,
            'id_curso' => 2,
            'nombre' => 'Fenómenos del sistema de potencia y su impacto en los relés de protección',
            'fecha_inicio' => '2014-08-11',
            'fecha_fin' => '2014-08-24',
            'descripcion' => 'Descripción...'
        );
        $this->db->insert('modulo', $data);

        $data = array(
            'id_modulo' => 10,
            'id_curso' => 2,
            'nombre' => 'Tópicos especiales en el análisis de fallas',
            'fecha_inicio' => '2014-08-25',
            'fecha_fin' => '2014-09-07',
            'descripcion' => 'Descripción...'
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
            'tipo' => 'pdf',
            'orden' => 1
        );
        $this->db->insert('material', $data);

        $data = array(
            'id_material' => 2,
            'id_modulo' => 1,
            'nombre' => 'La integral definida: definición, evaluación de integrales utilizando Sumas de Riemann, propiedades de la integral definida',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum.',
            'ubicacion' => '2.mp4',
            'tipo' => 'video',
            'duracion' => 960,
            'orden' => 2
        );
        $this->db->insert('material', $data);

        $data = array(
            'id_material' => 3,
            'id_modulo' => 1,
            'nombre' => 'Antiderivadas. Integrales indefinidas. Aplicaciones de las antiderivadas (movimiento rectilíneo).',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea.',
            'ubicacion' => '3.pdf',
            'tipo' => 'pdf',
            'orden' => 3
        );
        $this->db->insert('material', $data);

        $data = array(
            'id_material' => 4,
            'id_modulo' => 1,
            'nombre' => 'Evaluación de integrales definidas: Teorema de evaluación. Aplicaciones: Teorema de cambio total',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum.',
            'ubicacion' => '4.mp4',
            'tipo' => 'video',
            'duracion' => 960,
            'orden' => 4
        );
        $this->db->insert('material', $data);
        $data = array(
            'id_material' => 5,
            'id_modulo' => 1,
            'nombre' => 'Álgebra de funciones, composición de funciones',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum.',
            'ubicacion' => '2.mp4',
            'tipo' => 'video',
            'duracion' => 960,
            'orden' => 5
        );
        $this->db->insert('material', $data);

        $data = array(
            'id_material' => 6,
            'id_modulo' => 1,
            'nombre' => 'Funciones exponenciales: gráficas, leyes de los exponentes, modelación con funciones exponenciales, el número e',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum. Mei facer fabulas ut, id eum stet regione.',
            'ubicacion' => '1.pdf',
            'tipo' => 'pdf',
            'orden' => 6
        );
        $this->db->insert('material', $data);

        $data = array(
            'id_material' => 7,
            'id_modulo' => 1,
            'nombre' => 'Función inversa: función uno a uno, prueba de la recta horizontal, definición de función inversa, gráfica de la función inversa',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum. Mei facer fabulas ut, id eum stet regione.',
            'ubicacion' => '2.mp4',
            'tipo' => 'video',
            'duracion' => 960,
            'orden' => 7
        );
        $this->db->insert('material', $data);

        $data = array(
            'id_material' => 8,
            'id_modulo' => 1,
            'nombre' => 'Funciones logarítmicas: definición, gráficas, leyes de los logaritmos, logaritmo natural, fórmula para el cambio de base, gráfica de la función logaritmo natural',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum. Mei facer fabulas ut, id eum stet regione.',
            'ubicacion' => '2.mp4',
            'tipo' => 'video',
            'duracion' => 960,
            'orden' => 8
        );
        $this->db->insert('material', $data);

        $data = array(
            'id_material' => 9,
            'id_modulo' => 1,
            'nombre' => 'Funciones trigonométricas inversas: función seno inverso, función tangente inversa, función coseno inverso',
            'descripcion' => 'Lorem ipsum dolor sit amet, ex perfecto patrioque vim, per dolore animal ea. Ei integre moderatius intellegebat eum. Mei facer fabulas ut, id eum stet regione.',
            'ubicacion' => '1.pdf',
            'tipo' => 'pdf',
            'orden' => 9
        );
        $this->db->insert('material', $data);

        $data = array(
            'id_material' => 10,
            'id_modulo' => 6,
            'nombre' => 'Introducción a los sistemas de potencia I',
            'descripcion' => 'En este vídeo ...',
            'ubicacion' => '10.mp4',
            'tipo' => 'video',
            'orden' => 1
        );
        $this->db->insert('material', $data);

        $data = array(
            'id_material' => 11,
            'id_modulo' => 6,
            'nombre' => 'Introducción a los sistemas de potencia II',
            'descripcion' => 'En este vídeo ...',
            'ubicacion' => '11.mp4',
            'tipo' => 'video',
            'orden' => 2
        );
        $this->db->insert('material', $data);


        $data = array(
            'id_material' => 12,
            'id_modulo' => 6,
            'nombre' => 'Introducción a los sistemas de potencia III',
            'descripcion' => 'En este vídeo ...',
            'ubicacion' => '12.mp4',
            'tipo' => 'video',
            'orden' => 3
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

        $data = array(
            'id_evaluacion' => 5,
            'id_modulo' => 1,
            'orden' => 5,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 6,
            'id_modulo' => 1,
            'orden' => 6,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 7,
            'id_modulo' => 1,
            'orden' => 7,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 8,
            'id_modulo' => 1,
            'orden' => 8,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 9,
            'id_modulo' => 1,
            'orden' => 9,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 10,
            'id_modulo' => 1,
            'orden' => 10,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 11,
            'id_modulo' => 1,
            'orden' => 11,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 12,
            'id_modulo' => 2,
            'orden' => 1,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 13,
            'id_modulo' => 2,
            'orden' => 2,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 14,
            'id_modulo' => 2,
            'orden' => 3,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 15,
            'id_modulo' => 2,
            'orden' => 4,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 16,
            'id_modulo' => 2,
            'orden' => 5,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 17,
            'id_modulo' => 2,
            'orden' => 6,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 18,
            'id_modulo' => 2,
            'orden' => 7,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 19,
            'id_modulo' => 2,
            'orden' => 8,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 20,
            'id_modulo' => 2,
            'orden' => 9,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 21,
            'id_modulo' => 2,
            'orden' => 10,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 22,
            'id_modulo' => 2,
            'orden' => 11,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 23,
            'id_modulo' => 2,
            'orden' => 12,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 24,
            'id_modulo' => 2,
            'orden' => 13,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 25,
            'id_modulo' => 2,
            'orden' => 14,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 26,
            'id_modulo' => 2,
            'orden' => 15,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 27,
            'id_modulo' => 2,
            'orden' => 16,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 28,
            'id_modulo' => 2,
            'orden' => 17,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 29,
            'id_modulo' => 2,
            'orden' => 18,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 30,
            'id_modulo' => 2,
            'orden' => 19,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);


        $data = array(
            'id_evaluacion' => 31,
            'id_modulo' => 2,
            'orden' => 20,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 32,
            'id_modulo' => 2,
            'orden' => 21,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 33,
            'id_modulo' => 2,
            'orden' => 22,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 34,
            'id_modulo' => 2,
            'orden' => 23,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 35,
            'id_modulo' => 2,
            'orden' => 24,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 36,
            'id_modulo' => 2,
            'orden' => 25,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 37,
            'id_modulo' => 2,
            'orden' => 26,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 38,
            'id_modulo' => 2,
            'orden' => 27,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 39,
            'id_modulo' => 2,
            'orden' => 28,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 40,
            'id_modulo' => 2,
            'orden' => 29,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 41,
            'id_modulo' => 2,
            'orden' => 30,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 42,
            'id_modulo' => 6,
            'orden' => 1,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 43,
            'id_modulo' => 6,
            'orden' => 2,
            'id_tipo_evaluacion' => 1
        );
        $this->db->insert('evaluacion', $data);

        $data = array(
            'id_evaluacion' => 44,
            'id_modulo' => 6,
            'orden' => 2,
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
            'fecha_inicial' => '2014-06-30 12:14:44',
            'fecha_final' => '2014-06-30 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);

        $data = array(
            'id_usuario_evaluacion' => 2,
            'id_usuario' => 4,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-06-30 12:14:44',
            'fecha_final' => '2014-06-30 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);
        $data = array(
            'id_usuario_evaluacion' => 3,
            'id_usuario' => 6,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-06-30 12:14:44',
            'fecha_final' => '2014-06-30 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);
        $data = array(
            'id_usuario_evaluacion' => 4,
            'id_usuario' => 7,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-06-30 12:14:44',
            'fecha_final' => '2014-06-30 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);
        $data = array(
            'id_usuario_evaluacion' => 5,
            'id_usuario' => 8,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-06-30 12:14:44',
            'fecha_final' => '2014-06-30 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);
        $data = array(
            'id_usuario_evaluacion' => 6,
            'id_usuario' => 9,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-06-30 12:14:44',
            'fecha_final' => '2014-06-30 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);
        $data = array(
            'id_usuario_evaluacion' => 7,
            'id_usuario' => 10,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-06-30 12:14:44',
            'fecha_final' => '2014-06-30 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);
        $data = array(
            'id_usuario_evaluacion' => 8,
            'id_usuario' => 11,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-06-30 12:14:44',
            'fecha_final' => '2014-06-30 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);
        $data = array(
            'id_usuario_evaluacion' => 9,
            'id_usuario' => 12,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-06-30 12:14:44',
            'fecha_final' => '2014-06-30 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);
        $data = array(
            'id_usuario_evaluacion' => 10,
            'id_usuario' => 13,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-06-30 12:14:44',
            'fecha_final' => '2014-06-30 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);
        $data = array(
            'id_usuario_evaluacion' => 11,
            'id_usuario' => 14,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-06-30 12:14:44',
            'fecha_final' => '2014-06-30 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);

        $data = array(
            'id_usuario_evaluacion' => 12,
            'id_usuario' => 15,
            'id_evaluacion' => 1,
            'calificacion' => 1,
            'fecha_inicial' => '2014-06-30 12:14:44',
            'fecha_final' => '2014-06-30 12:15:50',
            'realimentacion' => 'Correcto'
        );
        $this->db->insert('usuario_x_evaluacion', $data);
    }

    private function usuario_x_material() {
        $this->db->empty_table('usuario_x_material');

        $data = array(
            'id_usuario' => 1,
            'id_material' => 2,
            'fecha_inicial' => '2014-06-30 12:14:44',
            'fecha_final' => '2014-06-30 12:15:50'
        );
        $this->db->insert('usuario_x_material', $data);

        $data = array(
            'id_usuario' => 1,
            'id_material' => 4,
            'fecha_inicial' => '2014-06-30 12:14:44',
            'fecha_final' => '2014-06-30 12:15:50'
        );
        $this->db->insert('usuario_x_material', $data);

        $data = array(
            'id_usuario' => 1,
            'id_material' => 1,
            'fecha_inicial' => '2014-06-30 12:14:44',
            'fecha_final' => '2014-06-30 12:25:50'
        );

        $this->db->insert('usuario_x_material', $data);
        $data = array(
            'id_usuario' => 1,
            'id_material' => 1,
            'fecha_inicial' => '2014-07-04 12:14:44',
            'fecha_final' => '2014-07-04 12:25:50'
        );
        $this->db->insert('usuario_x_material', $data);
    }

    private function usuario_x_modulo() {
        $this->db->empty_table('usuario_x_modulo');
        $data = array(
            'id_usuario' => 1,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);

        $data = array(
            'id_usuario' => 4,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);
        $data = array(
            'id_usuario' => 6,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);
        $data = array(
            'id_usuario' => 7,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);
        $data = array(
            'id_usuario' => 8,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);
        $data = array(
            'id_usuario' => 9,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);
        $data = array(
            'id_usuario' => 10,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);
        $data = array(
            'id_usuario' => 11,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);
        $data = array(
            'id_usuario' => 12,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);
        $data = array(
            'id_usuario' => 13,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);
        $data = array(
            'id_usuario' => 14,
            'id_modulo' => 1,
            'puntaje' => 250
        );
        $this->db->insert('usuario_x_modulo', $data);
        $data = array(
            'id_usuario' => 15,
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
        return;
        $data = array(
            'id_usuario_curso_logro' => 1,
            'id_usuario' => 4,
            'id_curso' => 1,
            'id_logro' => 1,
            'visto' => 1
        );
        $this->db->insert('usuario_curso_logro', $data);
    }

    private function muro() {
        $this->db->empty_table('muro');
        /*    $data = array(
          'id_muro' => 1,
          'id_curso' => 1,
          'id_usuario' => 1,
          'mensaje' => 1,
          'tipo' => 'logro'
          );
          $this->db->insert('muro', $data);
         */

        $data = array(
            'id_muro' => 2,
            'id_curso' => 1,
            'id_usuario' => 1,
            'mensaje' => 1,
            'mensaje' => 'Abcde'
        );
        $this->db->insert('muro', $data);

        /* $data = array(
          'id_muro' => 3,
          'muro_id_muro' => 1,
          'id_curso' => 1,
          'id_usuario' => 10,
          'mensaje' => "Felicitaciones!"
          );
          $this->db->insert('muro', $data);
         * */
    }

    private function bitacora_nivel() {
        $this->db->empty_table('bitacora_nivel');

        $data = array(
            'id_usuario' => 1,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-26 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 1,
            'id_curso' => 1,
            'id_nivel' => 2,
            'fecha' => '2014-06-27 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);



        $data = array(
            'id_usuario' => 4,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-26 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 4,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-27 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 5,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-27 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 6,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-26 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 6,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-27 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 7,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-26 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 7,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-27 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 8,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-26 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 8,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-27 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);



        $data = array(
            'id_usuario' => 9,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-26 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 9,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-27 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 10,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-26 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 10,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-27 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 11,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-26 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 11,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-27 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 12,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-26 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 12,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-27 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 13,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-26 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 13,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-27 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 14,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-26 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 14,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-27 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 15,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-26 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 15,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-27 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 16,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-26 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);

        $data = array(
            'id_usuario' => 16,
            'id_curso' => 1,
            'id_nivel' => 1,
            'fecha' => '2014-06-27 13:14:13'
        );
        $this->db->insert('bitacora_nivel', $data);
    }

    private function bitacora() {
        $this->db->empty_table('bitacora');

        $data = array(
            'id_usuario' => 1,
            'id_curso' => 1,
            'fecha_ingreso' => '2014-06-26 13:14:13',
            'fecha_salida' => '2014-06-26 13:14:13'
        );
        $this->db->insert('bitacora', $data);

        $data = array(
            'id_usuario' => 1,
            'id_curso' => 1,
            'fecha_ingreso' => '2014-06-25 13:14:13',
            'fecha_salida' => '2014-06-25 13:14:13'
        );
        $this->db->insert('bitacora', $data);

        $data = array(
            'id_usuario' => 1,
            'id_curso' => 1,
            'fecha_ingreso' => '2014-06-28 13:14:13',
            'fecha_salida' => '2014-06-28 15:15:13'
        );
        $this->db->insert('bitacora', $data);
    }

    private function evaluacion_x_material() {
        $this->db->empty_table('evaluacion_x_material');
        $data = array(
            'id_evaluacion' => 1,
            'id_material' => 1,
        );
        $this->db->insert('evaluacion_x_material', $data);

        $data = array(
            'id_evaluacion' => 2,
            'id_material' => 1,
        );
        $this->db->insert('evaluacion_x_material', $data);

        $data = array(
            'id_evaluacion' => 3,
            'id_material' => 2,
        );
        $this->db->insert('evaluacion_x_material', $data);

        $data = array(
            'id_evaluacion' => 4,
            'id_material' => 2,
        );
        $this->db->insert('evaluacion_x_material', $data);
    }

}
