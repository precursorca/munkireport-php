<?php

namespace munkireport\controller;

use \Controller, \View;
use Illuminate\Database\Query\JoinClause;
use \Machine_model, \Reportdata_model, \Disk_report_model, \Warranty_model, \Localadmin_model, \Security_model;



class clients extends Controller
{
    public function __construct()
    {
        if (! $this->authorized()) {
            redirect('auth/login');
        }

        // Connect to database
        $this->connectDB();

    }

    public function index()
    {

        $data['page'] = 'clients';

        $obj = new View();
        $obj->view('client/client_list', $data);
    }

    /**
     * Get some data for serial_number
     *
     * @author AvB
     **/
    public function get_data($serial_number = '')
    {
        $obj = new View();

        if (authorized_for_serial($serial_number)) {
            $db = $this->connectDB();
            $results = $db::table('machine')->select()
                ->leftJoin('reportdata', 'machine.serial_number', '=', 'reportdata.serial_number')
                ->leftJoin('security', 'machine.serial_number', '=', 'security.serial_number')
                ->leftJoin('warranty', 'machine.serial_number', '=', 'warranty.serial_number')
                ->leftJoin('localadmin', 'machine.serial_number', '=', 'localadmin.serial_number')
                ->leftJoin('diskreport', function ($join) {
                    $join->on('machine.serial_number', '=', 'diskreport.serial_number')
                        ->where('diskreport.mountpoint', '=', '/');
                })
                ->where('machine.serial_number', '=', $serial_number);

            $obj->view('json', array('msg' => $results->get()));
        } else {
            $obj->view('json', array('msg' => array()));
        }
    }

    /**
     * Retrieve links from config
     *
     * @author
     **/
    public function get_links()
    {
        $out = array();
        if (conf('vnc_link')) {
            $out['vnc'] = conf('vnc_link');
        }
        if (conf('ssh_link')) {
            $out['ssh'] = conf('ssh_link');
        }

        $obj = new View();
        $obj->view('json', array('msg' => $out));
    }

    // ------------------------------------------------------------------------

    /**
     * Detail page of a machine
     *
     * @param string serial
     * @return void
     * @author abn290
     **/
    public function detail($sn = '')
    {
        $data = array('serial_number' => $sn);
        $data['scripts'] = array("clients/client_detail.js");

        $obj = new View();

        $machine = new Machine_model($sn);

        // Check if machine exists/is allowed for this user to view
        if (! $machine->id) {
            $obj->view("client/client_dont_exist", $data);
        } else {
            $obj->view("client/client_detail", $data);
        }
    }

    // ------------------------------------------------------------------------

    /**
     * List of machines
     *
     * @param string name of view
     * @return void
     * @author abn290
     **/
    public function show($view = '')
    {
        $data['page'] = 'clients';
        // TODO: Check if view exists
        $obj = new View();
        $obj->view('client/'.$view, $data);
    }
}
