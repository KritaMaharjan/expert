<?php
namespace App\Http\Tenant\Statistics\Repositories;

use App\Http\Tenant\Email\Models\Email;
use App\Models\Tenant\Customer;
use Carbon\Carbon;

class CustomerRepository {

    private $from;
    private $to;
    /**
     * @return int
     * Total number of customers
     */
    function getCustomersTotal() {
        $total = Customer::whereBetween('created_at', array($this->from, $this->to))->count();
        return $total;
    }

    /**
     * @return int
     * Total number of sent emails
     */
    function getEmailsTotal() {
        $total = Email::whereBetween('created_at', array($this->from, $this->to))->count();
        return $total;
    }

    /**
     * @return int
     * Total number of active customers
     */
    function getActiveCustomers() {
        $total = Customer::where('status', 1)->whereBetween('created_at', array($this->from, $this->to))->count();
        return $total;
    }

    /**
     * @return array
     * Total Statistics for customers
     */
    function getCustomerStats($filter = null) {
        if($filter != null) {
            $this->from = $filter['start_date'];
            $this->to = $filter['end_date'];
        } else {
            $this->from = '0000-00-00';
            $this->to = Carbon::now();
        }
        $stats = array();
        $stats['total_customers'] = $this->getCustomersTotal();
        $stats['total_emails'] = $this->getEmailsTotal();
        $stats['total_active_customers'] = $this->getActiveCustomers();
        return $stats;
    }

}
