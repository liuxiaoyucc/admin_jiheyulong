<?php

namespace app\extra;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Mail
{
    public function sendMail($email, $subject = '', $body = '', $attach_file_path = '')
    {
        $mail = new PHPMailer(true);

        try {
            //服务端设置
            $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.qq.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = '2199842341@qq.com';                     //SMTP username
            $mail->Password   = 'rmdzqhgcnmswdjid';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //收件信息
            $mail->setFrom('2199842341@qq.com', 'liuxy');
            $mail->addAddress($email);     //Add a recipient
            $mail->addReplyTo('2199842341@qq.com', 'liuxy');

            // 附件
            if ($attach_file_path) {
                $mail->addAttachment($attach_file_path);         // 添加附件
            }

            // 正文
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject; // 主题
            $mail->Body    = $body; // 正文, 可html格式, 看isHTML参数是否支持;
            $mail->AltBody = '您的邮箱客户端不支持此内容显示!'; // 如果邮件客户端不支持HTML则显示此内容

            return $mail->send();
        } catch (Exception $e) {
            c_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
            return false;
        }
    }
}