<?php

function messages_exist()
{
    if (Session::has('errors')) {
        return true;
    }
    if (Session::has('logic_errors')) {
        return true;
    }
    if (Request::has('api_error')) {
        return true;
    }
    if (Session::has('successes')) {
        return true;
    }

    return false;
}

function messages_output()
{
    $output = '';
    if (Session::has('errors')) {
        $output .= '<div class="alert alert-danger"><ul>';
        foreach (Session::get('errors')->getBag('default')->all() as $error) {
            $output .= '<li>'.$error.'</li>';
        }
        $output .= '</ul></div>';
    }
    if (Session::has('logic_errors')) {
        foreach (Session::get('logic_errors') as $error) {
            if (is_string($error)) {
                $output .= '<div class="alert alert-danger">'.$error.'</div>';
            } else {
                foreach ($error as $errorEntry) {
                    if (is_array($errorEntry)) {
                        foreach ($errorEntry as $errorEntrySub) {
                            $output .= '<div class="alert alert-danger">'.$errorEntrySub.'</div>';
                        }
                    } else {
                        $output .= '<div class="alert alert-danger">'.$errorEntry.'</div>';
                    }
                }
            }
        }
    }
    if (Request::has('api_error')) {
        $output .= '<div class="alert alert-danger"><ul>';
        $output .= '<li>'.Request::get('api_error').'</li>';
        $output .= '</ul></div>';
    }
    if (Session::has('successes')) {
        foreach (Session::get('successes') as $success) {
            $output .= '<div class="alert alert-success">'.$success.'</div>';
        }
    }
    if ($output != '') {
        $output = '<div class="message-container">'.$output.'</div>';
    }

    return $output;
}

function messages()
{
    if (messages_exist()) {
        return '<div class="container">'.messages_output().'</div>';
    }

    return '';
}

function get_successes()
{
    $successes = [];
    if (Session::has('successes')) {
        $successes = Session::get('successes');
    }

    return $successes;
}

function success($message)
{
    if (! Session::has('successes')) {
        Session::flash('successes', []);
    }
    $successes = Session::get('successes');
    $successes[] = $message;
    Session::flash('successes', $successes);
}

