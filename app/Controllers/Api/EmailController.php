<?php namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Models\EmailLogModel;

class EmailController extends BaseController
{
\t/**
\t * @OA\Post(
\t *   path="/api/rest/email/send",
\t *   summary="Send Email via customer's SMTP",
\t *   security={{"ApiKeyAuth":{}}},
\t *   @OA\RequestBody(required=true, @OA\JsonContent(
\t *     required={"to","subject","html"},
\t *     @OA\Property(property="to", type="string", format="email"),
\t *     @OA\Property(property="subject", type="string"),
\t *     @OA\Property(property="html", type="string"),
\t *     @OA\Property(property="fromName", type="string")
\t *   )),
\t *   @OA\Response(response=200, description="OK")
\t * )
\t */
\tpublic function send()
\t{
\t\t$data = $this->request->getJSON(true) ?? [];
\t\t$to   = $data['to'] ?? null;
\t\t$subj = $data['subject'] ?? '';
\t\t$html = $data['html'] ?? '';
\t\tif (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
\t\t\treturn $this->response->setStatusCode(422)->setJSON(['error'=>['code'=>422,'description'=>'Invalid recipient email']]);
\t\t}

\t\t$user = $this->request->user;

\t\t$email = \Config\Services::email(null, false);
\t\t$email->initialize([
\t\t\t'protocol'   => 'smtp',
\t\t\t'SMTPHost'   => $user['smtp_host'],
\t\t\t'SMTPPort'   => (int)$user['smtp_port'],
\t\t\t'SMTPUser'   => $user['smtp_user'],
\t\t\t'SMTPPass'   => $user['smtp_pass'],
\t\t\t'SMTPCrypto' => $user['smtp_encryption'] ?: null,
\t\t\t'mailType'   => 'html',
\t\t\t'charset'    => 'utf-8',
\t\t\t'newline'    => "\r\n",
\t\t]);

\t\t$email->setFrom($user['smtp_from_email'], $data['fromName'] ?? $user['smtp_from_name'] ?? 'Kissai Alert');
\t\t$email->setTo($to);
\t\t$email->setSubject($subj);
\t\t$email->setMessage($html);

\t\t$log = new EmailLogModel();
\t\ttry {
\t\t\t$sent = $email->send(false);
\t\t\t$log->insert([
\t\t\t\t'user_id'   => $user['id'],
\t\t\t\t'to_email'  => $to,
\t\t\t\t'subject'   => $subj,
\t\t\t\t'status'    => $sent ? 'success' : 'error',
\t\t\t\t'error'     => $sent ? null : $email->printDebugger(['headers','subject','body']),
\t\t\t\t'message_id'=> method_exists($email, 'getMessageID') ? $email->getMessageID() : null,
\t\t\t\t'created_at'=> date('Y-m-d H:i:s'),
\t\t\t]);
\t\t\treturn $this->response->setJSON(['data'=>['success'=>$sent]]);
\t\t} catch (\Throwable $e) {
\t\t\t$log->insert([
\t\t\t\t'user_id'   => $user['id'],
\t\t\t\t'to_email'  => $to,
\t\t\t\t'subject'   => $subj,
\t\t\t\t'status'    => 'error',
\t\t\t\t'error'     => $e->getMessage(),
\t\t\t\t'created_at'=> date('Y-m-d H:i:s'),
\t\t\t]);
\t\t\treturn $this->response->setStatusCode(500)->setJSON(['error'=>['code'=>500,'description'=>'Send failed']]);
\t\t}
\t}
}

