var app = angular.module('myApp', []);
app.controller('productsCtrl', function ($scope, $http) {
    var $form = $('#new_product');
    // more angular JS codes will be here
    $scope.showCreateForm = function () {
        // clear form
        $scope.clearForm();

        // change modal title
        $('#modal-product-title').text("Create New Product");

        // hide update product button
        $('#btn-update-product').hide();

        // show create product button
        $('#btn-create-product').show();

        $('#modal-product-form').openModal();
    };

    // clear variable / form values
    $scope.clearForm = function () {
        $scope.id = '';
        $scope.name = '';
        $scope.description = '';
        $scope.price = '';
    };

    $scope.create = function () {
        $.post('product/create', $form.serialize()).success(function (data) {
            console.log(data);
            Materialize.toast(data, 4000);

            //close modal
            $('#modal-product-form').closeModal();

            //clear modal content
            $scope.clearForm();

            //refresh the list
            $scope.getAll();
        });
    };

    $scope.getAll = function () {
        $http.get('product/all').success(function (response) {
            $scope.names = response.records || [];
        }).error(function (data, status, headers, config) {
            Materialize.toast('Unable to retrieve any record.', 4000);
        });
    };

    //receive record to fill out the form
    $scope.readOne = function (id) {
        //change modal title
        $('#modal-product-title').text("Edit Product");

        // show udpate product button
        $('#btn-update-product').show();

        // hide create product button
        $('#btn-create-product').hide();

        //get product by id
        $http.get('product/find?id=' + id).success(function (data) {
            // puts the values in form
            $scope.id = data.id;
            $scope.name = data.name;
            $scope.description = data.description;
            $scope.price = data.price;
            // show modal
            $('#modal-product-form').openModal();
        }).error(function (data, status, headers, config) {
            Materialize.toast('Unable to retrieve record.', 4000);
        });
    };

    //update product record - save changes
    $scope.update = function () {
        $http.post('product/update', {
            id: $scope.id,
            name: $scope.name,
            description: $scope.description,
            price: $scope.price
        }).success(function (data) {
            // tell the user product record was updated
            Materialize.toast(data, 4000);

            // close modal
            $('#modal-product-form').closeModal();

            // clear modal content
            $scope.clearForm();

            // refresh the product list
            $scope.getAll();
        })
    };

    //delete product
    $scope.delete = function (id) {
        if (confirm('Are you sure?')) {
            $http.delete('product/delete?id=' + id).success(function (data) {
                // tell the user product was deleted
                Materialize.toast(data, 4000);

                // refresh the list
                $scope.getAll();
            });
        }
    }
});