<html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    background-color: #f4f4f4;
                    color: #333;
                    padding: 20px;
                    margin: 0;
                }
    
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                }
    
                h1 {
                    color: #3498db;
                }
    
                p {
                    margin-bottom: 20px;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h1>New Space Application</h1>
                <p>Dear Space Owner,</p>
                <p>A new application has been submitted for space <strong><?php echo $spaceName ?></strong> by tenant <strong><?php echo $tenant ?></strong>.</p>
                <p>Regards,<br>Concessionaire Monitoring Operation System</p>
            </div>
        </body>
        </html>