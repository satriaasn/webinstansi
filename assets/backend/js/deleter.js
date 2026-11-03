var deleter = {
    linkSelector: "a[data-delete]",
    modalTitle: "Are you sure?",
    modalMessage: "You will not be able to recover this entry.",
    modalConfirmButtonText: "Yes",
    laravelToken: null,
    url: "/",

    init: function () {
        $(this.linkSelector).on('click', {self: this}, this.handleClick);
    },

    handleClick: function (event) {
        event.preventDefault();

        var self = event.data.self;
        var link = $(this);

        self.modalTitle = link.data('title') || self.modalTitle;
        self.modalMessage = link.data('message') || self.modalMessage;
        self.modalConfirmButtonText = link.data('button-text') || self.modalConfirmButtonText;
        self.url = link.attr('href');
        self.laravelToken = $("meta[name=csrf-token]").attr('content');

        self.confirmDelete();
    },

    confirmDelete: function () {
        var that = this;

        swal({
            title: this.modalTitle,
            text: this.modalMessage,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: this.modalConfirmButtonText,
            confirmButtonClass: 'btn btn-danger btn-sm mg-r-10',
            cancelButtonClass: 'btn btn-default btn-sm mg-l-10',
            buttonsStyling: false,
            animation: false,
            focusConfirm: false,
        }).then(function (result) {
            if (result.value) {
                var form =
                    $('<form>', {
                        'method': 'POST',
                        'action': that.url
                    });

                var token =
                    $('<input>', {
                        'type': 'hidden',
                        'name': '_token',
                        'value': that.laravelToken
                    });

                var hiddenInput =
                    $('<input>', {
                        'name': '_method',
                        'type': 'hidden',
                        'value': 'DELETE'
                    });

                form.append(token, hiddenInput).appendTo('body').submit();
            }
        });
    }
};

deleter.init();