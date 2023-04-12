<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

/*$string = file_get_contents("config.json");
$option = json_decode($string);

define("MAIL_HOST", $option->MAIL_HOST);
define("MAIL_TITLE", $option->MAIL_TITLE);*/

$str_to_save = "";

try {

    // https://soyvision.com/mail/contact_me.php?name=Robson&mail=robson.pierangeli@gmail.com&phone=999753256&message=teste
    if( isset($_GET['name']) && isset($_GET['mail'])) {
        $str_name = $_GET['name'];
        $str_email = $_GET['mail'];
        $str_phone = $_GET['phone'];
        $str_msg = nl2br($_GET['message']);

        $str_msg = 'Nome: ' . $str_name . ' Email: ' . $str_email . 'Fone: ' . $str_phone . ' Mensagem:' . $str_msg;

        echo "Send mail";

        // Instancio a classe PHPMailer
        $msg = new PHPMailer();

        // Faço todas as configurações de SMTP para o envio da mensagem
        $msg->CharSet = "UTF-8";
        $msg->isSMTP();
        $msg->Host = 'rpgsoftware.com.br';
        $msg->SMTPAuth = true;
        $msg->Username = 'contato@rpgsoftware.com.br';
        $msg->Password = 'TobilloRPG#2015';
        $msg->Port = 587;
        $msg->SMTPAutoTLS = false;
        $msg->AuthType = 'PLAIN';

        //Defino o remetente da mensagem
        $msg->setFrom('contato@rpgsoftware.com.br', 'RPG Software Landpage');

        // Defino a quem esta mensagem será respondida, no caso, para o e-mail
        // que foi cadastrado no formulário
        $msg->addReplyTo($str_email, $str_name);

        // Defino a mensagem como mensagem de texto (Ou seja não terá formatação HTML)
        $msg->IsHTML(false);

        // Adiciono o destinatário desta mensagem, no caso,
        $msg->AddAddress('robson.pierangeli@gmail.com', 'Robson');
        $msg->AddAddress('contato@rpgsoftware.com.br', 'Contato');

        // Defino o assunto que foi digitado no formulário
        $msg->Subject = 'Mensagem recebida RPG Software Landpage';

        // Defino a mensagem que foi digitada no formulário
        $msg->Body = $str_msg;

        // Defino a mensagem alternativa que foi digitada no formulário.
        // Esta mensagem é utilizada para validações AntiSPAM e por isto
        // é muito recomendado que utilize-a
        $msg->AltBody = $str_msg;

        // Faço o envio da mensagem
        $enviado = $msg->Send();

        // Limpo todos os registros de destinatários e arquivos
        $msg->ClearAllRecipients();

        // Caso a mensagem seja enviada com sucesso ela retornará sucesso
        // senão, ela retornará o erro ocorrido
        if ($enviado) {
            echo "Mensagem enviada com sucesso!";
            //header('Location: /index.html');
            //die();
        } else {
            echo "Não foi possível enviar a Mensagem.";
            //echo "<b>Informações do erro:</b> " . $msg->ErrorInfo;
        }
    }
} catch (Exception $e) {
    // Aconteceu erro
    echo $e->errorMessage();
    //file_put_contents("autorizations.txt", $str_to_save, FILE_APPEND);
} finally {
    //header("Location: https://rest.philo.solutions/auth/auth.php");
}

?>

