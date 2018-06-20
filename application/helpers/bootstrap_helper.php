<?php

function messagens($tp,$msg)
    {
        $cl = array('alert-primary','alert-secondary','alert-success',
                        'alert-danger','alert-warning','alert-info',
                        'alert-light','alert-dark');
        if (isset($cl[$tp]))
            {
                $class = $cl[$tp];
            } else {
                $class = $cl[1];
            }
        $sx = '
            <div class="alert '.$class.'" role="alert">
                '.$msg.'
            </div>';
        return($sx);
    }
