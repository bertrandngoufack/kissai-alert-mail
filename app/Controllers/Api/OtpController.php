<?php namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Libraries\OtpGenerator;
use App\Models\OtpModel;

class OtpController extends BaseController
{
\t/**
\t * @OA\Post(
\t *   path="/api/rest/otp/generate",
\t *   summary="Generate OTP",
\t *   security={{"ApiKeyAuth":{}}},
\t *   @OA\RequestBody(required=true, @OA\JsonContent(
\t *     required={"recipient"},
\t *     @OA\Property(property="recipient", type="string"),
\t *     @OA\Property(property="alpha", type="boolean", default=false),
\t *     @OA\Property(property="length", type="integer", default=4, minimum=3, maximum=10),
\t *     @OA\Property(property="maxAttempts", type="integer", default=3, minimum=1, maximum=10),
\t *     @OA\Property(property="maxSecondsValidity", type="integer", default=60, minimum=30, maximum=6000),
\t *     @OA\Property(property="appId", type="string", default="")
\t *   )),
\t *   @OA\Response(response=200, description="OK")
\t * )
\t */
\tpublic function generate()
\t{
\t\t$payload = $this->request->getJSON(true) ?? [];
\t\t$recipient = $payload['recipient'] ?? null;
\t\tif (!$recipient || !filter_var($recipient, FILTER_VALIDATE_EMAIL) && !preg_match('/^\+?[0-9]{6,15}$/', $recipient)) {
\t\t\treturn $this->response->setStatusCode(422)->setJSON(['error'=>['code'=>422,'description'=>'The recipient field must be a valid phone or email.']]);
\t\t}

\t\t$alpha   = (bool)($payload['alpha'] ?? false);
\t\t$length  = max(3, min((int)($payload['length'] ?? 4), 10));
\t\t$maxAtt  = max(1, min((int)($payload['maxAttempts'] ?? 3), 10));
\t\t$maxSec  = max(30, min((int)($payload['maxSecondsValidity'] ?? 60), 6000));
\t\t$appId   = (string)($payload['appId'] ?? '');
\t\t$reject  = (bool)($payload['rejectIfPendingCode'] ?? false);

\t\t$userId = $this->request->user['id'];

\t\t$otpModel = new OtpModel();

\t\tif ($reject) {
\t\t\t$pending = $otpModel->where(['user_id'=>$userId,'recipient'=>$recipient,'status'=>'pending'])->first();
\t\t\tif ($pending) {
\t\t\t\treturn $this->response->setStatusCode(409)->setJSON(['error'=>['code'=>409,'description'=>'Pending OTP exists.']]);
\t\t\t}
\t\t}

\t\t$code   = OtpGenerator::generateCode($length, $alpha);
\t\t$now    = new \DateTimeImmutable('now');
\t\t$exp    = $now->modify("+{$maxSec} seconds");

\t\t$otpModel->insert([
\t\t\t'user_id'              => $userId,
\t\t\t'recipient'            => $recipient,
\t\t\t'code'                 => $code,
\t\t\t'alpha'                => $alpha ? 1 : 0,
\t\t\t'length'               => $length,
\t\t\t'max_attempts'         => $maxAtt,
\t\t\t'max_seconds_validity' => $maxSec,
\t\t\t'app_id'               => $appId,
\t\t\t'expires_at'           => $exp->format('Y-m-d H:i:s'),
\t\t], true);

\t\t$data = [
\t\t\t"recipient"          => $recipient,
\t\t\t"code"               => $code,
\t\t\t"attempts"           => 0,
\t\t\t"maxAttempts"        => $maxAtt,
\t\t\t"maxSecondsValidity" => $maxSec,
\t\t\t"appId"              => $appId,
\t\t\t"createdAt"          => $now->format(DATE_ATOM),
\t\t\t"updatedAt"          => $now->format(DATE_ATOM),
\t\t\t"expiresAt"          => $exp->format(DATE_ATOM),
\t\t];

\t\treturn $this->response->setJSON(['data'=>$data]);
\t}

\t/**
\t * @OA\Post(
\t *   path="/api/rest/otp/check",
\t *   summary="Check OTP",
\t *   security={{"ApiKeyAuth":{}}},
\t *   @OA\RequestBody(required=true, @OA\JsonContent(
\t *     required={"recipient","code"},
\t *     @OA\Property(property="recipient", type="string"),
\t *     @OA\Property(property="code", type="string")
\t *   )),
\t *   @OA\Response(response=200, description="OK")
\t * )
\t */
\tpublic function check()
\t{
\t\t$payload = $this->request->getJSON(true) ?? [];
\t\t$recipient = $payload['recipient'] ?? null;
\t\t$code      = $payload['code'] ?? null;

\t\tif (!$recipient) {
\t\t\treturn $this->response->setStatusCode(422)->setJSON(['error'=>['code'=>422,'description'=>'The recipient field is required.']]);
\t\t}

\t\t$userId  = $this->request->user['id'];
\t\t$otpModel = new OtpModel();

\t\t$otp = $otpModel->where(['user_id'=>$userId,'recipient'=>$recipient])
\t\t\t->orderBy('id','DESC')->first();

\t\t$valid = false; $reason = 'NotFound';
\t\tif ($otp) {
\t\t\t$now = new \DateTimeImmutable('now');
\t\t\t$expired = $now > new \DateTimeImmutable($otp['expires_at']);
\t\t\tif ($expired) {
\t\t\t\t$otpModel->update($otp['id'], ['status'=>'expired']);
\t\t\t\t$reason = 'Expired';
\t\t\t} elseif ((int)$otp['attempts'] >= (int)$otp['max_attempts']) {
\t\t\t\t$reason = 'MaxAttempts';
\t\t\t} else {
\t\t\t\t$attempts = (int)$otp['attempts'] + 1;
\t\t\t\t$valid = hash_equals($otp['code'], (string)$code);
\t\t\t\t$otpModel->update($otp['id'], [
\t\t\t\t\t'attempts' => $attempts,
\t\t\t\t\t'status'   => $valid ? 'validated' : 'pending'
\t\t\t\t]);
\t\t\t\t$reason = $valid ? 'Valid' : 'Invalid';
\t\t\t}
\t\t}

\t\t$resp = [
\t\t\t'data' => [
\t\t\t\t'valid'  => $valid,
\t\t\t\t'reason' => $reason,
\t\t\t\t'otp'    => $otp ? ['data'=>[
\t\t\t\t\t"recipient"          => $otp['recipient'],
\t\t\t\t\t"code"               => $otp['code'],
\t\t\t\t\t"attempts"           => (int)$otp['attempts'] + 1,
\t\t\t\t\t"maxAttempts"        => (int)$otp['max_attempts'],
\t\t\t\t\t"maxSecondsValidity" => (int)$otp['max_seconds_validity'],
\t\t\t\t\t"appId"              => $otp['app_id'],
\t\t\t\t\t"createdAt"          => date(DATE_ATOM, strtotime($otp['created_at'])),
\t\t\t\t\t"updatedAt"          => date(DATE_ATOM),
\t\t\t\t\t"expiresAt"          => date(DATE_ATOM, strtotime($otp['expires_at'])),
\t\t\t\t]] : null
\t\t\t]
\t\t];

\t\treturn $this->response->setJSON($resp);
\t}
}

