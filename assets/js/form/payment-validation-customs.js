"use strict";
(function () {
  "use strict";
  window.addEventListener(
    "load",
    function () {
      var forms = document.getElementsByClassName("payment-validation");
      var validation = Array.prototype.filter.call(forms, function (form) {
        form.addEventListener(
          "submit",
          function (event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            } else {
              event.preventDefault();
              let url = $("#addPayment").attr("action");
              let data = $("#addPayment").serialize();
              let title = $("#questionPayment").val();
              Swal.fire({
                icon: "question",
                title: title,
                showDenyButton: true,
                showCancelButton: false,
                confirmButtonText: "ใช่",
                denyButtonText: "ยกเลิก",
              }).then((result) => {
                if (result.isConfirmed) {
                  $.ajax({
                    url: url,
                    type: "POST",
                    data: data,
                    success: function (res) {
                      let { status, message } = JSON.parse(res);

                      if (status) {
                        Swal.fire({
                          title: message,
                          icon: "success",
                          showConfirmButton: false,
                          timer: 1000,
                        }).then(() => {
                          window.location.reload();
                        });
                      } else {
                        Swal.fire({
                          title: message,
                          icon: "error",
                          showConfirmButton: false,
                          timer: 1000,
                        });
                      }
                    },
                  });
                }
              });
            }
            form.classList.add("was-validated");
          },
          false
        );
      });
    },
    false
  );
})();
