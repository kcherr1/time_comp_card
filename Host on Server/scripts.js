var submitDelay = null;
var btnSubmitting = null;
var btnSubmit = null;

$(document).ready(function() {
  submitDelay = parseFloat($('#nextDelay').text());
  btnSubmitting = $('#submitting');
  btnSubmit = $('#submit');
});

function submitLoading() {
  btnSubmit.css('display', 'none');
  btnSubmitting.val('Checking answers...');
  btnSubmitting.css('display', 'inline');
  if (!isNaN(submitDelay) && submitDelay > 0) {
    updateDelayDisplay();
  }
}

function updateDelayDisplay() {
  btnSubmitting.val('Checking answers... wait ' + submitDelay.toFixed(1) + ' seconds');
  submitDelay -= 0.1;
  if (submitDelay >= 0) {
    window.setTimeout('updateDelayDisplay()', 98);
  }
}
