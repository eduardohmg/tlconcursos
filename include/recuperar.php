<?php
	include('config.php');
	GerarToken($_POST['email']);
	
	function GerarToken($email)
	{
		try
		{
			$sql_email = mysql_query("SELECT * FROM usuario WHERE email = '".$email."'");
			$result_email = mysql_fetch_assoc($sql_email);
			$numrows = mysql_num_rows($sql_email);
			if($numrows > 0)
			{
				$token = "";
				
				while(true)
				{
					$token = md5(uniqid(rand(), true));
					$token .= md5(uniqid(rand(), true));
					
					$sql_vtoken = mysql_query("SELECT * FROM token_senha WHERE token = '".$token."'");
					
					if(mysql_num_rows($sql_vtoken) <= 0)
					{
						$sql_ctoken = mysql_query("INSERT INTO token_senha(token, validade, dt_utilizacao, utilizado, id_usuario) VALUES('".$token."','7','','0','".$result_email['id_usuario']."')");
						break;
					}
				}
				
				$link = "http://localhost/Redefinir?token=".$token;
				
				// Enviar o link contendo o token por e-mail
				
				require_once('PHPMailer_5.2.4/class.phpmailer.php'); //chama a classe de onde você a colocou.

				$mail = new PHPMailer(); // instancia a classe PHPMailer

				$mail->IsSMTP();

				//configuração do gmail
				$mail->Port = '465'; //porta usada pelo gmail.
				$mail->Host = 'smtp.gmail.com'; 
				$mail->IsHTML(true); 
				$mail->Mailer = 'smtp'; 
				$mail->SMTPSecure = 'ssl';

				//configuração do usuário do gmail
				$mail->SMTPAuth = true; 
				$mail->Username = 'email@gmail.com'; // usuario gmail.   
				$mail->Password = 'senha'; // senha do email.

				$mail->SingleTo = true; 

				// configuração do email a ver enviado.
				//$mail->From = "E-mail automático - Não responder";
				$mail->FromName = "TL Concursos"; 

				$mail->addAddress($email); // email do destinatario.

				$mail->Subject = "Redefinir senha de conta - TL Concursos - (E-mail automatico. Nao responder)"; 
				$mail->Body = "Olá, ".$result_email['nome'].".<br><br>
				Você solicitou a recuperação de senha para a sua conta no nosso sistema. Para efetuar a refinição da sua senha, por favor, siga os seguintes passos:<br><br><br><br>
				- Clique no link seguinte: (".$link.")<br><br>
				- Digite uma nova senha para a sua conta<br><br>
				- Confirme a sua nova senha<br><br>
				- Pronto! Você já pode acessar a sua conta pela nova senha!<br><br>
				Aproveite todos os nossos recursos e Bons estudos!<br><br>
				
				Atenciosamente,<br><br>
				Equipe TL Concursos<br><br><br>
				--<br><br>
				Atenção, este é um e-mail automático, por favor, não responda.<br>
				Se quiser nos enviar alguma sugestão/crítica/notificação, utilize o formulário dedicado para isso na página principal do TL Concursos.";

				if(!$mail->Send())
				{
					echo "Erro ao enviar Email:" . $mail->ErrorInfo;
					return true;
				}
				
				echo "1";
				return true;
			}
			else
			{
				echo "0";
				return true;
			}
		}
		catch(Exception $e)
		{
			echo "erro";
			return false;
		}
	}
?>