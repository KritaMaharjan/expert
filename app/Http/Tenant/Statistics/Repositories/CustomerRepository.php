<?php
namespace App\Http\Tenant\Statistics\Repositories;

use App\Http\Tenant\Email\Models\Email;
use App\Models\Tenant\Customer;

class CustomerRepository {

    /**
     * @return int
     * Total number of customers
     */
    function getCustomersTotal() {
        $total = Customer::count();
        return $total;
    }

    /**
     * @return int
     * Total number of sent emails
     */
    function getEmailsTotal() {
        $total = Email::count();
        return $total;
    }

    /**
     * @return int
     * Total number of active customers
     */
    function getActiveCustomers() {
        $total = Customer::where('status', 1)->count();
        return $total;
    }

    /**
     * @return array
     * Total Statistics for customers
     */
    function getCustomerStats() {
        $stats = array();
        $stats['total_customers'] = $this->getCustomersTotal();
        $stats['total_emails'] = $this->getEmailsTotal();
        $stats['total_active_customers'] = $this->getActiveCustomers();
        return $stats;
    }

}
