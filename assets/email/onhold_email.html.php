<!DOCTYPE html>
<html lang="en">
<head></head>
<body>
<p>Dear <?php echo $tenant; ?>,</p>
<p>We hope this message finds you well.</p>
<p>We would like to remind you of the importance of completing the lease application process for the concession space located at <strong><?php echo $conAddress; ?></strong>. As part of the application requirements, we kindly request that you submit the physical copies of the necessary documentation within the next 14 days. These documents are essential for processing your application and finalizing the lease agreement.
Please ensure that all required documents are submitted in hard copy format to our office address:
<?php echo $office_address; ?></p>

<p>Failure to comply with this request within the specified timeframe will result in the restart of your application process. This means that your application will be considered void, and you will need to resubmit all necessary documents to proceed with the application.
We understand the importance of a smooth and efficient application process and appreciate your cooperation in this matter. Should you have any questions or require further assistance, please do not hesitate to contact us at <?php echo $owner_email; ?>.</p>

<p>Thank you for your attention to this matter.</p>
<br />
<p>Best regards,</p>
<br />
<br />
<p style="font-weight: bold"><?php echo $owner; ?></p>
<p>Concourse Owner</p>
<p><?php echo $owner_email; ?></p>
</body>
</html>