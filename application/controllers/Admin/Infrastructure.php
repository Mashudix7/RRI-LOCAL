<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Infrastructure extends Admin_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->_check_role_access(['admin', 'management', 'auditor']);
    }

    // Network
    public function network_traffic_mrtg()
    {
        $data['user'] = $this->_get_user_data();
        $data['title'] = 'Traffic MRTG';
        $data['page'] = 'network_traffic_mrtg';
        
        $this->render_admin('admin/security/network_traffic_mrtg', $data);
    }

    /**
     * JSON endpoint: /admin/infrastructure/mrtg_data
     * Returns Zabbix MRTG data for the frontend chart view.
     */
    public function mrtg_data()
    {
        $this->load->model('Zabbix_model');
        $data = $this->Zabbix_model->get_mrtg_data();
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function network_traffic_ap()
    {
        $data['user'] = $this->_get_user_data();
        $data['title'] = 'Traffic Access Point';
        $data['page'] = 'network_traffic_ap';
        
        $this->render_admin('admin/infrastructure/security/network_traffic_ap', $data);
    }

    // Data Center
    public function datacenter_resource_server()
    {
        $data['user'] = $this->_get_user_data();
        $data['title'] = 'Server Resource';
        $data['page'] = 'datacenter_resource_server';
        
        $this->render_admin('admin/infrastructure/datacenter/resource_server', $data);
    }

    public function datacenter_traffic_vm()
    {
        $data['user'] = $this->_get_user_data();
        $data['title'] = 'Traffic Virtual Machine';
        $data['page'] = 'datacenter_traffic_vm';
        
        $this->render_admin('admin/infrastructure/datacenter/traffic_vm', $data);
    }

    // Security
    public function security_waf_activity()
    {
        $data['user'] = $this->_get_user_data();
        $data['title'] = 'Aktivitas Serangan WAF';
        $data['page'] = 'security_waf_activity';
        
        $this->render_admin('admin/infrastructure/security/waf_activity', $data);
    }

    public function security_fortigate()
    {
         $data['user'] = $this->_get_user_data();
        $data['title'] = 'Fortigate';
        $data['page'] = 'security_fortigate';
        
        $this->render_admin('admin/infrastructure/security/fortigate', $data);
    }
    
    // Satellite
     public function satellite_starlink()
    {
         $data['user'] = $this->_get_user_data();
        $data['title'] = 'Starlink';
        $data['page'] = 'satellite_starlink';
        
        $this->render_admin('admin/infrastructure/satellite/starlink', $data);
    }
    
    public function satellite_broadcast_audio()
    {
         $data['user'] = $this->_get_user_data();
        $data['title'] = 'Siaran Audio (Broadcast)';
        $data['page'] = 'satellite_broadcast_audio';
        
        $this->render_admin('admin/infrastructure/satellite/broadcast_audio', $data);
    }
}
