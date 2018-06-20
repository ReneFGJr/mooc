<?php
class moocs extends Ci_model {

    function le_module($id = 0) {
        $sql = "select * from module
                    INNER JOIN cource ON m_course = id_c 
                    where id_m = $id
                    ORDER BY m_order, c_active desc, c_name";
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        if (count($rlt) > 0) {
            $line = $rlt[0];            
            $line['parts'] = $this->le_parts($line['id_m']);
            return ($line);
        } else {
            return ( array());
        }
    }
    
    function le_parts($id)
        {
            $sql = "select * from part
                        LEFT JOIN content ON cc_module = p_module AND cc_part = id_p
                        LEFT JOIN type ON cc_type = id_t
                        WHERE p_module = $id";
            $rlt = $this->db->query($sql);
            $rlt = $rlt->result_array();
            return($rlt);
        }

    function course($id = 0) {
        $sql = "select * from cource
                    INNER JOIN place on c_place = id_pl
                     
                    ORDER BY c_active desc, c_name";
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();

        $line = $rlt[0];
        $link = '<a href="' . base_url(PATH . 'course/' . $line['id_c']) . '">';
        $linka = '</a>';

        $sx = '
        <div class="row">
            <div class="col-12">
                <span class="course">' . msg('Courses') . '</span>
            </div>

            <div class="col-12">
                <span class="cs_title">' . $line['c_name'] . '</span>
                <br>
                <span class="cs_place">' . $line['pl_name'] . '</span>
            </div>
        </div>' . cr();

        return ($sx);
    }

    function courses() {
        $sql = "select * from cource
                    INNER JOIN place on c_place = id_pl 
                    ORDER BY c_active desc, c_name";
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();
        $sx = '<div class="row">';
        $sx .= '    <div class="col-12">' . cr();
        $sx .= '    <span class="courses">' . msg('Courses') . '</span>';
        $sx .= '    </div>' . cr();
        for ($r = 0; $r < count($rlt); $r++) {
            $line = $rlt[$r];
            $link = '<a href="' . base_url(PATH . 'course/' . $line['id_c']) . '">';
            $linka = '</a>';
            $sx .= '<div class="col-md-4 com-lg-6 col-xs-8 col-sm-12 divx shadown_box margin5" style="min-height: 350px;">' . cr();
            $sx .= $link;
            $sx .= '<img src="' . base_url('img/background/2.jpg') . '" class="img-fluid img">';

            $sx .= '<div style="min-height: 10px; background-color: #008000;"></div>';

            $sx .= '<div class="pad5">';
            $sx .= '<span class="cs_place">' . $line['pl_name'] . '</span>';
            $sx .= '<br>';
            $sx .= '<span class="cs_title">' . $line['c_name'] . '</span>' . cr();
            $sx .= '</div>' . cr();
            $sx .= '</div>' . cr();
            $sx .= '</a>';
            //            $sx .= '</div>' . cr();
        }
        $sx .= '</div>' . cr();
        return ($sx);
    }

    function modules($id = '') {
        $sql = "select * from module
                    INNER JOIN cource ON m_course = id_c 
                    where id_c = $id
                    ORDER BY m_order, c_active desc, c_name";
        $rlt = $this -> db -> query($sql);
        $rlt = $rlt -> result_array();

        $sx = '<div class="row">';
        $sx .= '    <div class="col-12">' . cr();
        $sx .= '    <span class="course">' . $rlt[0]['c_name'] . '</span>';
        $sx .= '    <br><span class="module">' . msg('Modules') . '</span>';
        $sx .= '    </div>' . cr();
        $sx .= '</div>' . cr();

        for ($r = 0; $r < count($rlt); $r++) {
            $line = $rlt[$r];
            if ($line['m_ativo'] == 1) {
                $link = '<a href="' . base_url(PATH . 'module/' . $line['id_m']) . '">';
                $linka = '</a>';
                $class = "";
            } else {
                $link = '';
                $linka = '';
                $class = "disable";
            }
            $sx .= '<div class="row">';
            $sx .= '    <div class="col-1">' . cr();
            $sx .= '    </div>' . cr();
            $sx .= '    <div class="col-11">' . cr();
            $sx .= '        <span class="course ' . $class . '">' . $link . $line['m_name'] . $linka . '</span>' . cr();
            $sx .= '    </div>' . cr();
            $sx .= '</div>' . cr();

        }
        return ($sx);
    }

    function show_youtube($line) {
        $class = '';
        $link = '<a href="' . $line['cc_content'] . '" target="new_' . $line['id_cc'] . '" class="' . $class . '">';
        $linka = '</a>';

        $sx = '
                <div class="row">
                    <div class="col-md-2">
                    </div>
                    <div class="col-md-1 text-center">
                    <img id="my-img" src="' . base_url('img/icone/icone-youtube_0.png') . '"  class="img-fluid"/>
                    </div>
                    <div class="col-md-9 conteudo">
                        '.$link.'<span class="conteudo">'.$line['cc_name'].'</span>'.$linka.'
                    </div>
                </div>                
                ';

        //$sx .= '<div class="col-md-10">';
        //$sx .= '<span class="module">';
        //$sx .= $link .  . $linka;
        //$sx .= '</span><br>';
        //$sx .= $link . '<span class="small">'.msg('see_video').'</span>' . $linka;
        //$sx .= '</div>';
        return ($sx);
    }

    function show_module($line) {
        $sx = '';
        $sx .= ' 
            <div class="row">
                <div class="col-md-12 borderb module">
                    <span class="module">' . $line['m_name'] . '</span>
                </div>
            </div>';
        $sx .= cr();
        return ($sx);
    }

    function show_part($line) {
        $sx = '';
        $sx .= ' 
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-11 borderb part">
                    <span class="part">' . $line['p_name'] . '</span>
                </div>
            </div>';
        $sx .= cr();
        return ($sx);
    }

    function show_content($line) {
        $type = $line['t_cod'];
        $sx = '';
        $t = '0';
        if ($t == '0') {
            $class = 'text-secondary';
        } else {
            $class = 'text-primary';
        }
        switch ($type) {
            case 'YOUTB' :
                $sx .= $this -> show_youtube($line);
                break;
            case 'TEXT' :
                break;
            case '' :
                break;
        }

        return ($sx);
    }


    function module($id = '') {
        $rlt = $this->le_module($id);
        $sx = '';
        $sx .= $this -> show_module($rlt);
        
        for ($r = 0; $r < count($rlt['parts']); $r++) {
            $line = $rlt['parts'][$r];
            $sx .= $this -> show_part($line);            
            $sx .= $this -> show_content($line);

        }
        return ($sx);
    }

}
?>
