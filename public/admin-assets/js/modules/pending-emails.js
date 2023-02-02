
var $emailBody = $('#emailBody');
var $subject = $('#subject');
var $email = $('#email');
var $time = $('#time');
var $date = $('#date');
var $isApprovedStatus = $('#isApprovedStatus');

var ttags = [];
var bbrand = 0;
var eemailType = 0;
var emailId = 0;



function empty ()
{
   
    $emailBody.text('');
    $subject.text('');
    $email.text('');
    $time.text('');
    $date.text('');
    $isApprovedStatus.text('');
    $('#noneAtt').text('');
    $('#att').html('');

    $('#attHeader').css('display', 'none');
}


var $cLoadingEffect = $('.c-loading-eff');
var $emailBodyEffect = $('#emailBodyEffect'); 


$('body').on('click', '.v-email-cont', function (e) {

     // reset selects
     resetSelects();

    emailId = $(this).data('eid');
    console.log('eid: ' + emailId);

    //$('#downloadImageBtn').attr('href', '/emails/get-email-image/' + emailId);
   //$('#downloadPdfBtn').attr('href', '/emails/get-email-pdf/' + emailId);


    empty();
    $('#viewEmailSrcBtn').css('display', 'none');
    $emailBodyEffect.css('display', 'block');
    $cLoadingEffect.css('display', 'block');
    $('#emailView').addClass('email-view-open ');

    axios.get('/emails/get-email-content/' + emailId)
    .then(({data}) => {
        console.log(data);

        var email = data.email;

        $subject.text(email.title);
        $email.text(email.email);

        var time = moment(email.email_content.email_time_stamp);

        $time.text( time.format('LT') + ' ( ' + time.fromNow() + ' )');

        $date.text(time.format('MMMM Do YYYY'));

        $isApprovedStatus.text(email.is_approved == 0 ? 'NO' : 'YES');

        // handle email attachments
        var $emailAttachments = email.email_content.email_attachments;
        console.log($emailAttachments);

        if ($emailAttachments.length > 0) {
            $('#none').css('display', 'none');

            $('#attHeader').css('display', 'table-row');

            var count = 1;

            var html = ``;

            $emailAttachments.forEach(function(att) {

                 html += `<tr>
                <td class="p-1"> 
                    ${count++}
                </td class="p-1">
                <td class="p-1"> 
                    ${att.name}
                </td>
                <td class="p-1"> 
                    <a href="${att.path}">   <i  class="fas text-primary c-icon fa-fw fa-download"></i> </a>
                </td>
                </tr>`;

            });
           

            $('#att').html(html);

        } else {
            $('#attHeader').css('display', 'none');


            $('#noneAtt').text('None');
            $('#none').css('display', 'block');
        }

       

        // email content
        //$emailBody.html(data.email.email_content.body);
        //$emailBodyEffect.css('display', 'none');
        
        $cLoadingEffect.css('display', 'none');
       

    }).catch((error) => {
     
        $cLoadingEffect.css('display', 'none');

    });

    // getting email body content html fragment
    axios.get( '/emails/get-email-html/' +  emailId )
        .then(({data}) => {
            console.log(data);

            var wrappedHtml = '<div>' + data + '</div>';
            var noScript = wrappedHtml.replace(/script/g, "SCRIPTNOTALLOWED");
            
            eeaajj.forEach(function (acc) {
                acc = acc.trim().toLowerCase();
                var reg = new RegExp(acc + '.com', "g");
                noScript = noScript.replace(reg, "[Protected Email]");
                var reg = new RegExp(acc, "g");
                noScript = noScript.replace(reg, "[Protected Email]");
            });


            
            var html = $(noScript);
            html.find('SCRIPTNOTALLOWED').remove();
            html.find('base').remove();
        
            // remove email internal styles
            html.find('style').remove();

            // remove unsubscribe link
            var hrefs = html.find('a');
            for( i = 0; i < hrefs.length; i++ ) {
                if (   hrefs[i].innerHTML.trim().toLowerCase().includes('unsubscribe') ) {
                    console.log(hrefs[i]);
                    $(hrefs[i]).remove();
                }
            }

            
            $emailBody.html(html);
            $('#emailSourceCode').text(data);
            $('#viewEmailSrcBtn').css('display', 'inline-block');

            // remove email internal styles
            // $('#emailBody').find('style').remove();
            $emailBodyEffect.css('display', 'none');

            //document.write(data)
        }).catch((e) => {
        });
    

});


$('#closeBtn').on('click', function (e) {
    $('#emailView').removeClass('email-view-open ');
});


$('#tagsSelect').selectpicker();
$('#tagsSelect').on('change', function (e) {
        ttags = $(this).val();
});


$('#bbSelect').selectpicker();
bbrand = $('#bbSelect').val();

// $('#bbSelect').on('change', function (e) {
//     if ( $(this).val() ) {
//         bbrand = $(this).val();
//     }
// });

$('#eemailType').selectpicker();
$('#eemailType').on('change', function (e) {
    if ( $(this).val() ) {
        eemailType = $(this).val();
    }
});

$('#aApprovedBtn').on('click', function (e) {
    console.log(ttags);
    console.log(bbrand);
    console.log(eemailType);

    $('#aApprovedBtn').prop('disabled', true);

    axios.post("/emails/pending/approve-with-parms", {
        emailId: emailId,
        brandId: bbrand,
        tagIds: ttags,
        typeId: eemailType
    }).then(({
        data
    }) => {

        console.log(data);
        $('#aApprovedBtn').prop('disabled', false);
        if (data.success) {

            pendingEmailsDataTable.draw();

            Toast.fire({
                icon: 'success',
                title: data.message,
            });

            $('#emailView').removeClass('email-view-open');
            // get updated pending and approved emails count

        
            return getPendingApprovedEmailsCount();

          

        } else {


            Toast.fire({
                icon: 'info',
                title: data.message
            });

        }


    }).then((data) => {
        // updating pending and approved emails lables here
        console.log(data);

        $('#pEmailsCount').text(data.pendingEmailsCount);
        $('#aEmailsCount').text(data.approvedEmailsCount);

    })
    .catch((error) => {
        $('#aApprovedBtn').prop('disabled', false);
    });


}); 

 var resetSelects = function () {
    $('#tagsSelect').selectpicker('deselectAll');
    $('#eemailType').selectpicker('val', 0);
    $('#eemailType').selectpicker('refresh');
 }



