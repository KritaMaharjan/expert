<?php
namespace App\Http\Tenant\Statistics\Repositories;

use App\Http\Tenant\Collection\Models\CourtCase;
use App\Http\Tenant\Invoice\Models\Bill;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Tenant\Collection\Models\Collection;

class CollectionRepository {

    private $from;
    private $to;
    private $chartData;

    /**
     * @return int
     * Total number of cases
     */
    function getTotalCases() {

        $total = CourtCase::whereBetween('created_at', array($this->from, $this->to))->count();
        return $total;
    }

    /**
     * @return int
     * Total number of bills listed as collection
     */
    function getTotalBills() {
        $total = Bill::where('type', 0)->where('status', 1)->whereBetween('created_at', array($this->from, $this->to))->count();
        return $total;
    }

    /**
     * @return float
     * Total amount in Collection
     */
    function getTotalAmount() {
        $total = Bill::select('total')->where('type', 0)->where('status', 1)->whereBetween('created_at', array($this->from, $this->to))->sum('total');
        return float_format($total);
    }

    /**
     *
     * @return int
     * Total cases in particular stage
     */
    function getCasesByStep($step = '')
    {
        $status = [BILL::STATUS_COLLECTION];
        $select = [DB::raw('MAX(col.step) as step'), 'b.total as total'];

        $step_string = $step == '' ? 'purring' : $step;
        $step = Collection::getStep($step_string);

        $query = Bill::select($select)->from('fb_bill as b')
            ->leftJoin('fb_collection as col', 'col.bill_id', '=', 'b.id')
            //->whereIn('b.status', $status)// get bills having collection status
            ->where('b.is_offer', BILL::TYPE_BILL)// get only bill type
            ->whereBetween('b.created_at', array($this->from, $this->to))
            ->groupBy('b.id')
            ->having('step', '=', $step)
            ->get();

        $result = array('total' => count($query), 'amount' => float_format($query->sum('total')));
        return $result;
    }

    /**
     * @return array
     * Total number of collection activity each day
     */
    function getChartData() {

        $totalBills = $this->getCasesChartData();
        $chartData = array();
        foreach($totalBills as $data) {
            $chartData[] = ['x' => $data->date, 'value1' => $data->total, 'value2' => 0, 'value3' => 0, 'value4' => 0, 'value5' => 0];
        }
        $this->chartData = $chartData;

        //$pastDueBills = $this->getPastDueChartData();
        $collectionBills = $this->getBillsChartData();
        $this->addOrCreateArray($collectionBills, 2);

        $totalPurring = $this->getCasesByStepChartData('purring');
        $this->addOrCreateArray($totalPurring, 3);

        $totalInkassovarsel = $this->getCasesByStepChartData('inkassovarsel');
        $this->addOrCreateArray($totalInkassovarsel, 4);

        $totalBetalingsappfording = $this->getCasesByStepChartData('betalingsappfording');
        $this->addOrCreateArray($totalBetalingsappfording, 5);

        return ($this->chartData);
    }

    function addOrCreateArray($new_data, $index) {
        foreach($new_data as $data) {
            $exists = $this->in_assoc($data->date, $this->chartData);
            if($exists  !== false)
                $this->chartData[$exists]['value'.$index] = $data->total;
            else {
                $this->chartData[]['x'] = $data->date;
                end($this->chartData);
                //get key of the last array
                $key = key($this->chartData);

                for($i = 1; $i <= 5; $i++)
                {
                    if($i == $index)
                        $this->chartData[$key]['value'.$i] = $data->total;
                    else
                        $this->chartData[$key]['value'.$i] = 0;
                }
            }
        }
    }

    //check if a value exists in associative array
    function in_assoc($needle, $array)
    {
        foreach ($array as $key => $val) {
            if ($val['x'] == $needle) {
                return $key;
            }
        }
        return false;
    }

    function getCasesByStepChartData($step = '')
    {
        $step_string = $step == '' ? 'purring' : $step;
        $step = Collection::getStep($step_string);

        $select = [
            'b.id',
            DB::raw('MAX(c.step) as step'),
            DB::raw('DATE(MAX(c.created_at)) AS ddate')];

        $allCollections = Bill::select($select)
                    ->from('fb_bill as b')
                    ->join('fb_collection as c', 'c.bill_id', '=', 'b.id')
                    ->where('b.is_offer', BILL::TYPE_BILL)// get only bill type
                    ->whereBetween('c.created_at', array($this->from, $this->to))
                    ->groupBy('b.id')
                    ->having('step', '=', $step)
                    ->get()
                    ->toArray();

        $dates = array();
        foreach ($allCollections as $collection) {
            $dates[] = $collection['ddate'];
        }
        //count duplicate entries for a date
        $total_values = array_count_values($dates);

        $chartDatas = array();
        foreach($total_values as $key => $val) {
            //$chartData = array('date' => $key, 'total' => $val);
            $chartData = array('date' => $key, 'total' => $val);
            $chartData = (object)$chartData;
            array_push($chartDatas, $chartData);
        }
        return $chartDatas;
    }

    /*
     * total customers
     */
    function getCasesChartData() {
        $chartDatas = CourtCase::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS total'),
        ])
            ->whereBetween('created_at', array($this->from, $this->to))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();
        return $chartDatas;
    }

    /*
     * total customers
     */
    function getBillsChartData() {
        $chartDatas = Bill::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS total'),
        ])
            ->where('type', 0)
            ->where('status', 1)
            ->whereBetween('created_at', array($this->from, $this->to))
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get();
        return $chartDatas;
    }

    /**
     * @return array
     * Statistics for Collection section
     */
    function getCollectionStats($filter = null) {
        if($filter != null) {
            $this->from = $filter['start_date'];
            $this->to = $filter['end_date'];
        } else {
            $this->from = '0000-00-00';
            $this->to = Carbon::now();
        }

        $stats = array();
        $stats['collection_chart_data'] = $this->getChartData();
        $stats['total_cases'] = $this->getTotalCases();
        $stats['total_bills'] = $this->getTotalBills();
        $stats['total_amount'] = $this->getTotalAmount();
        $stats['total_purring'] = $this->getCasesByStep('purring');
        $stats['total_inkassovarsel'] = $this->getCasesByStep('inkassovarsel');
        $stats['total_betalingsappfording'] = $this->getCasesByStep('betalingsappfording');
        $stats['total_utlegg'] = $this->getCasesByStep('utlegg');
        return $stats;
    }

}
