<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
<p>Dear, <?php echo $tenant; ?>,</p>

<p>We are pleased to inform you that we are ready to finalize the turnover process for the concession space located at <?php echo $conAddress; ?>,.
As discussed, we kindly request your presence to complete the following steps to ensure a smooth transition:</p>

<ol>
    <li>
        Submission of Hard Copies of Requirements:
        <ul>
            <li>
                Please bring the hard copies of all required documentation, including the lease application form, identification documents, financial statements, and any additional documents outlined in your lease agreement.
            </li>
        </ul>
    </li>
    <li>
        Finalization of Lease Agreement:
        <ul>
            <li>
                We will be providing the final lease agreement for your review and signature. We require your presence to finalize the lease contract with wet signatures.
            </li>
        </ul>
    </li>
    <li>
        Key Handover:
        <ul>
            <li>
                Upon completion of the lease agreement, we will provide you with the keys to the concession space for immediate access.
            </li>
        </ul>
    </li>
</ol>

<p>Meeting Details:
    <ul>
        <li>Date: <?php echo $meetdate; ?></li>
        <li>Time: <?php echo $meettime; ?></li>
    </ul>
</p>

<p>Location:
    <ul>
        <li> <?php echo $office_address; ?></li>
    </ul>
</p>

<p>Please ensure that you arrive promptly at the designated time and bring all necessary documents with you. This will allow us to efficiently complete the turnover process and ensure that you can begin utilizing the space as soon as possible.</p>

<p>Should you have any questions or require further clarification, please do not hesitate to contact us at <?php echo $owner_email; ?>.</p>
<br/>
<p>We look forward to finalizing the turnover process and welcoming you as a tenant in our <?php echo $conName; ?> community.</p>
<br />

<p><strong>Note: <a href="https://docs.google.com/document/d/10x94Rw0q2Eb9WqoR8RPncD8BYqAUgrVJ/edit?usp=sharing&ouid=106068628885874930178&rtpof=true&sd=true">Click Here</a> to download the file, it's a copy of lease document that need to be submit.<</p>
<br />
<p>Best regards,</p>
<br />
<br />
<p style="font-weight: bold"><?php echo $owner; ?></p>
<p>Concourse Owner</p>
<p><?php echo $owner_email; ?></p>
</body>
</html>