<?php
namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use SoftDeletes;

    protected $table       = "ITOperations.email.queue";
    protected $date_format = 'Y-m-d H:i:s';

    public function getDateFormat()
    {
        return 'Y-m-d H:i:s';
    }

    public static function sendEmail ($to_address, $from_address, $subject, $body) {
      $email = new Email;
      $email->to_email   = $to_address;
      $email->from_email = $from_address;
      $email->subject    = $subject;
      $email->body       = $body;
      $email->template   = "campusmailer.official";
      $email->created_by = $email->updated_by = "0000001";
      $email->save();
    }
}
