$(document).ready(function() {

	function checkForm($form) {
		var showFormIncomplete = function() {
			$(".form-incomplete").show();
		};

		var $name = $form.children("[name='name']");
		var $mail = $form.children("[name='email']");
		var $phone = $form.children("[name='phone']");

		if (!$name.val()) {
			$name.addClass("error-input");
			showFormIncomplete();
			return false;
		}

		if (!$mail.val() && !$phone.val()) {
			$mail.addClass("error-input");
			$phone.addClass("error-input");
			showFormIncomplete();
			return false;
		}

		return true;
	}

	(function setUpForms() {
		var closeModalWindow = function() {
			$(".md-show").removeClass("md-show");
			$(".error-input").removeClass('error-input');
			$(".form-incomplete").hide();
		};

		var showErrorMessage = function() {
			closeModalWindow();
			$("#popup-form").css("z-index", 5);
			$(".form-fail").addClass("md-show");
		};

		var showSuccessMessage = function() {
			closeModalWindow();
			$("#popup-form").css("z-index", 5);
			$(".form-done").addClass("md-show");
		};

		$(".trigger-trimmed-form").click(function()  {
			$("#popup-form-trimmed").addClass("md-show");
		});

		$(".trigger-form").click(function()  {
			$("#popup-form").addClass("md-show");
		});


		$(".close-button").click(function() {
			closeModalWindow();
		});

		$(".md-overlay").click(function(){
			closeModalWindow();
		});

		$("form").each(function() {
			var $form = $(this);
			$form.find("[type='submit']").click(function() {
				if (checkForm($form)) {
					$.ajax({
							type: "POST",
							url: "formdata.php",
							data: $form.serialize(),
							success: function(data) {
								showSuccessMessage();
							},
							error: function(jqXHR, textStatus, errorThrown) {
								showErrorMessage();
							}

					});
				}
				return false;
			});
		});

		//not forms, I'm just lazy
		$('#documents-trigger').click(function(){
			$("#documents").addClass("md-show");
			return false;
		});

	})();
});
