<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService {

    private function createMailer() {
        $mail = new PHPMailer(true);

        $this->baseConfig($mail);

        $mail->CharSet = 'UTF-8';

        return $mail;
    }

    private function baseConfig(PHPMailer $mail) {

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'diegoandressc1227@gmail.com';
        $mail->Password = 'qehr zokw wnii tdjb';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->CharSet = 'UTF-8';
        $mail->Port = 587;

        $mail->setFrom('diegoandressc1227@gmail.com', 'Sistema de Four Seasons');
    }

    public function sendWelcome($email, $name) {

        $mail = $this->createMailer();

        try {

            $mail->addAddress($email, $name);
            $mail->isHTML(true);
            $mail->Subject = "Bienvenido 👋";

            $mail->Body = "
                <div style='font-family: Arial, sans-serif; background-color:#111; padding:20px;'>

                    <div style='max-width:600px; margin:auto; background-color:#1c1c1c; border-radius:10px; overflow:hidden; border:1px solid #333;'>

                        <div style='background-color:#000; padding:20px; text-align:center;'>
                            <h2 style='color:#ffffff; margin:0; font-size:22px;'>
                                Bienvenido a nuestro sistema, $name 👋
                            </h2>
                        </div>

                        <div style='padding:25px; color:#d1d1d1; line-height:1.6;'>

                            <p style='font-size:16px;'>
                                Esperamos que todas las estadías que vaya a tener en <strong style='color:#ffffff;'>Four Seasons</strong> sean de todo su agrado.
                            </p>

                            <p style='font-size:15px; color:#b5b5b5;'>
                                Nos alegra tenerte, de parte de los dueños de esta hermosa empresa.
                            </p>

                            <hr style='border:0; border-top:1px solid #333; margin:20px 0;'>

                            <p style='font-size:13px; color:#777; text-align:center;'>
                                Este es un mensaje automático, por favor no responder.
                            </p>

                        </div>

                    </div>

                </div>
            ";

            return $mail->send();

        } catch (Exception $e) {
            return false;
        }
    }

    public function sendBookingInfo($email, $name, $bookingData) {

        $mail = $this->createMailer();

        try {

            $mail->addAddress($email, $name);
            $mail->isHTML(true);
            $mail->Subject = "Bienvenido 👋";

            $mail->Body = "
                <div style='font-family: Arial, sans-serif; background-color:#111; padding:25px;'>

                    <div style='max-width:600px; margin:auto; background-color:#1b1b1b; border-radius:12px; overflow:hidden; border:1px solid #2e2e2e;'>

                        <!-- HEADER -->
                        <div style='background-color:#000; padding:25px; text-align:center;'>
                            <h2 style='color:#fff; margin:0;'>
                                🏨 Reserva Creada
                            </h2>

                            <p style='color:#999; margin-top:8px;'>
                                Four Seasons Hotel
                            </p>
                        </div>

                        <div style='padding:25px; color:#d4d4d4;'>

                            <p style='font-size:16px;'>
                                Hola <strong style='color:white;'>{$name}</strong>, tu reserva ha sido registrada correctamente.
                            </p>

                            <div style='background:#101010; border:1px solid #2e2e2e; border-radius:10px; padding:20px; margin:20px 0;'>

                                <p><strong>🏷️ Categoría:</strong> {$bookingData['Categoria_de_habitacion']}</p>

                                <p><strong>🛏️ Habitación:</strong> {$bookingData['Numero_de_habitacion']}</p>

                                <p><strong>📅 Fecha de entrada:</strong> {$bookingData['Fecha_de_inicio']}</p>

                                <p><strong>📅 Fecha de salida:</strong> {$bookingData['Fecha_de_final']}</p>

                                <p><strong>👥 Cantidad de huéspedes:</strong> {$bookingData['Numero_de_huespedes']}</p>

                                <p><strong>📌 Estado:</strong> {$bookingData['Estado_de_reserva']}</p>

                                <p><strong>💳 Método de pago:</strong> {$bookingData['Metodo_de_pago']}</p>

                            </div>

                            <div style='text-align:center; margin:30px 0;'>

                                <p style='font-size:14px; color:#999; margin-bottom:5px;'>
                                    TOTAL PAGADO
                                </p>

                                <h2 style='color:#fff; margin:0;'>
                                    $ {$bookingData['Total_a_pagar']}
                                </h2>

                            </div>

                            <hr style='border:0; border-top:1px solid #2e2e2e; margin:25px 0;'>

                            <p style='font-size:13px; color:#8d8d8d; text-align:center;'>
                                Gracias por confiar en Four Seasons 😄
                            </p>

                        </div>

                    </div>

                </div>
                ";

            return $mail->send();

        } catch (Exception $e) {
            return false;
        }
        //Pendiente, crear la estancia e invocar la funcion en la parte de la creacion del booking
    }
}
?>