<?php

require_once('vendor' . DS . 'shuchkin/simplexlsx' . DS . 'src' . DS . 'SimpleXLSX.php');

class MemberController extends AppController {
    
    public function add() {
        // migration file upload
        if ($this->request->isPost() && isset($this->request->data['Member']['file'])) {
            // debug ('upload to members-transactions-transaction_items');
            // exit;

            $file = $this->request->data['Member']['file'];	

            if (!file_exists($file['tmp_name'])) {
                $this->setFlash('File not found');
            } else {
                // mime
                $finfo = finfo_open( FILEINFO_MIME_TYPE );
                $mtype = finfo_file( $finfo, $file['tmp_name'] );
                finfo_close( $finfo );
                $mimes = array('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

                // extension
                $ary_ext=array('xlsx'); //array of allowed extensions
                $ext = substr(strtolower(strrchr($file['name'], '.')), 1); //get the extension

                // mime type check
                if(!in_array($mtype,$mimes)) {
                    $this->setFlash('MIME type not allowed');
                } else if(!in_array($ext, $ary_ext)) { 
                    $this->setFlash('Invalid file extension');
                } else {
                    $dest_file = DS . WWW_ROOT . 'files' . DS .'uploaded' . DS;
                    $filename = $dest_file . time() . $file['name'];
                    move_uploaded_file($file['tmp_name'], $filename);

                    $this->migrateMembers($filename);
                    $this->setFlash('Migration Complete.');
                }
            }

        } else {
            $this->setFlash('Question: Migration of data to multiple DB table');
        }
    }

	private function migrateMembers($xlsxFile) {  

        // Reading sheet :Sheet2
        // DateRef No.Member NameMember NoMember Pay TypeMember CompanyPayment ByBatch NoReceipt NoCheque NoPayment DescriptionRenewal Yearsubtotaltotaltaxtotal

        if ( $xlsx = @SimpleXLSX::parse($xlsxFile) ) {

            // Sheet numeration started 0
            $sheets=$xlsx->sheetNames();
        
            $members = array();
            $transactions = array();
            $transaction_items = array();

            foreach($sheets as $index => $name){
                echo "Reading sheet :".$name."<br>";
                $xlsx->rows($index);
                foreach ($xlsx->rows($index) as $r => $row) {
                    if ($r == 0) continue;
                    $col_ctr = 1;
                    foreach($row as $col) {
                        switch ($col_ctr) {

                            case 1:
                                $transactions[$r]['date'] = trim(str_replace('00:00:00', '', $col));
                                $date  = explode("-", $col);
                                $year  = $date[0];
                                $month = $date[1];
                                $day   = $date[2];
                                $transactions[$r]['year'] = $year;
                                $transactions[$r]['month'] = $month;
                                break;

                            case 2:
                                $transactions[$r]['ref_no'] = $col;
                                break;

                            case 3:
                                $members[$r]['name'] = $col;
                                $transactions[$r]['member_name'] = $col;
                                break;

                            // members:type + members:no
                            case 4: 
                                $split = explode(" ", $col);
                                $members[$r]['type'] = $split[0];
                                $no = preg_replace("/[^0-9]/", "", $split[1]);
                                $members[$r]['no'] = $no;
                                break;

                            case 5:
                                $transactions[$r]['member_paytype'] = $col;
                                // debug($transactions[$r]); exit;
                                break;

                            case 6:
                                $members[$r]['company'] = $col;
                                $transactions[$r]['member_company'] = $col;
                                break;

                            case 7:
                                $transactions[$r]['payment_method'] = $col;
                                break;

                            case 8:
                                $transactions[$r]['batch_no'] = $col;
                                break;

                            case 9:
                                $transactions[$r]['receipt_no'] = $col;
                                break;

                            case 10:
                                $transactions[$r]['cheque_no'] = $col;
                                break;

                            case 11:
                                $transaction_items[$r]['description'] = $col;
                                break;

                            case 12:
                                $transactions[$r]['renewal_year'] = $col;
                                break;

                            case 13:
                                $transactions[$r]['subtotal'] = $col;
                                break;

                            case 14:
                                $transactions[$r]['tax'] = $col;
                                break;

                            case 15:
                                $transactions[$r]['total'] = $col;
                                break;
                        }
                        $col_ctr++;
                    }
                }
            }

            // debug ($transaction_items); exit;

            $this->Member->saveAll($members);
            $member_ids = $this->Member->inserted_ids;

            // bind member id to transactions FK member_id
            foreach($transactions as $key=>$value ) {
                $transactions[$key]['member_id'] = $member_ids[$key-1];
            }

            $this->loadModel('Transaction');
            $this->Transaction->saveAll($transactions);
            $transaction_ids = $this->Transaction->inserted_ids;
            
            // bind member id to transaction_items FK transaction_id
            foreach($transaction_items as $key=>$value ) {
                $transaction_items[$key]['transaction_id'] = $transaction_ids[$key-1];
            }
            $this->loadModel('TransactionItem');
            $this->TransactionItem->saveAll($transaction_items);
        
        } else{
            echo SimpleXLSX::parseError();
        }
    }
}