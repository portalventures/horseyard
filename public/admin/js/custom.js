var barchartHeight = 250;
var postImAages = [];
if ($("#chart").length) {
  barchartHeight = $("#chart").parent().height() - 80;
}
var currentlyOpened = $(".has-submenu > a.opened");
var chartOptions = {
  height: barchartHeight,
  bars: [{
    values: [
      ["Jan", 2500],
      ["Feb", 7500],
      ["Mar", 75000],
      ["Apr", 2500],
      ["May", 7500],
      ["Jun", 25000],
      ["Jul", 75000],
      ["Aug", 2500],
      ["Sep", 40000],
      ["Oct", 60000],
      ["Nov", 7500],
      ["Dec", 40000],
    ]
  },],
  colors: [
    "#D2D2D2"
  ],
}
var chartOptionsDashboard = {
  height: 159,
  bars: [{
    values: [
      ["Jan", 2500],
      ["Feb", 5500],
      ["Mar", 7500],
      ["Apr", 2500],
      ["May", 5500],
      ["Jun", 2500],
      ["Jul", 7500],
      ["Aug", 2500],
      ["Sep", 6000],
      ["Oct", 8000],
      ["Nov", 7500],
      ["Dec", 4000],
    ]
  },],
  colors: [
    "#D2D2D2"
  ],
}
var listingTypeHorses = '<div class="card-type">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">Price<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<div class="d-flex flex-column">' +
  '<input type="text" class="form-control checkvalidity" placeholder="Enter Price" required>' +
  '<span class="errorMessage"></span>' +
  '<span class="text-orange field-info">Enter price in numbers only (eg. 100 or 1000 or 10000)<br>Do not use full stops or commas (eg. 1,000 or 100.00)</span>' +
  '</div>' +
  '</div>' +
  '<div class="col col-md-6 pl-5">' +
  '<div class="d-flex mt-2">' +
  '<label for="" class="mb-0 mr-3">Item show type</label>' +
  '<div class="d-flex">' +
  '<label for="item-free" class="custom-radio mr-3 mb-0">' +
  '<input type="radio" name="item-type" id="item-free">' +
  '<span></span>' +
  'Free' +
  '</label>' +
  '<label for="item-negotiable" class="custom-radio mr-3 mb-0">' +
  '<input type="radio" name="item-type" id="item-negotiable" checked>' +
  '<span></span>' +
  'Negotiable' +
  '</label>' +
  '<label for="item-ono" class="custom-radio mr-3 mb-0">' +
  '<input type="radio" name="item-type" id="item-ono">' +
  '<span></span>' +
  'ONO' +
  '</label>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="card-type">' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">Country<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Country" id="country" class="form-control checkvalidity" required>' +
  '<option value="">Select</option>' +
  '<option value="2">Country</option>' +
  '</select>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">Suburb<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Country" id="suburb" class="form-control checkvalidity" required>' +
  '<option value="">Select</option>' +
  '<option value="2">Suburb</option>' +
  '</select>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">State<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Country" id="state" class="form-control checkvalidity" required>' +
  '<option value="">Select</option>' +
  '<option value="2">State</option>' +
  '</select>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">PIC</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<div class="d-flex flex-column">' +
  '<input type="text" placeholder="PIC Number" class="form-control">' +
  '<span class="text-orange field-info">Enter your PIC (Property Identification Code) here</span>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="card-type">' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">Title<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-10">' +
  '<input type="text" placeholder="Title of Ad" class="form-control checkvalidity" required>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">Description<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-10">' +
  '<textarea name="" id="" cols="30" rows="5" placeholder="Description of Ad" class="form-control checkvalidity" required></textarea>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="card-type">' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">Horse Name<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<input type="text" placeholder="Name" class="form-control checkvalidity" required>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">Horse Registration No.<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<input type="text" placeholder="Registration No." class="form-control checkvalidity" required>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">Sire</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<input type="text" placeholder="Sire" class="form-control">' +
  '</div>' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">Dam</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<input type="text" placeholder="Dam" class="form-control">' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="card-type">' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">Discipline<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Country" id="discipline" class="form-control checkvalidity" required>' +
  '<option value="">Select</option>' +
  '<option value="2">Country</option>' +
  '</select>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">Temperament</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Temperament" id="temperament" class="form-control">' +
  '<option value="">Select</option>' +
  '<option value="2">Temperament</option>' +
  '</select>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">Breed (Primary)<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Breed" id="breed" class="form-control checkvalidity" required>' +
  '<option value="">Select</option>' +
  '<option value="2">Breed</option>' +
  '</select>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">Age</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Age" id="age" class="form-control">' +
  '<option value="">Select</option>' +
  '<option value="2">Age</option>' +
  '</select>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">Breed (Secondary)</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Breed secondary" id="breedSecondary" class="form-control">' +
  '<option value="">Select</option>' +
  '<option value="2">Breed</option>' +
  '</select>' +
  '</div>' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">Rider Level</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Rider Level" id="rider" class="form-control">' +
  '<option value="">Select</option>' +
  '<option value="2">Rider Level</option>' +
  '</select>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">Color</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Color" id="color" class="form-control">' +
  '<option value="">Select</option>' +
  '<option value="2">Color</option>' +
  '</select>' +
  '</div>' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">Height</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Height" id="height" class="form-control">' +
  '<option value="">Select</option>' +
  '<option value="2">Height</option>' +
  '</select>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right">Gender</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Gender" id="gender" class="form-control">' +
  '<option value="">Select</option>' +
  '<option value="2">Gender</option>' +
  '</select>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="step-actions">' +
  '<button class="btn btn-secondary previous-step" type="button">Prev</button>' +
  '<button class="btn btn-primary next-step" type="button">Next</button>' +
  '</div>';
var listingTypeSaddlery = '<div class="card-type">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Price<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<div class="d-flex flex-column">' +
  '<input type="text" class="form-control checkvalidity" placeholder="Enter Price" required name="Price">' +
  '<span class="text-orange field-info">Enter price in numbers only (eg. 100 or 1000 or 10000)<br>Do not use full stops or commas (eg. 1,000 or 100.00)</span>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '</div>' +
  '<div class="col col-md-6 pl-5">' +
  '<div class="d-flex mt-2">' +
  '<label for="" class="mb-0 mr-3">Item show type</label>' +
  '<div class="d-flex">' +
  '<label for="item-free" class="custom-radio mr-3 mb-0">' +
  '<input type="radio" name="item-type" id="item-free">' +
  '<span></span>' +
  'Free' +
  '</label>' +
  '</div>' +
  '</label>' +
  '<label for="item-negotiable" class="custom-radio mr-3 mb-0">' +
  '<input type="radio" name="item-type" id="item-negotiable" checked>' +
  '<span></span>' +
  'Negotiable' +
  '</label>' +
  '<label for="item-ono" class="custom-radio mr-3 mb-0">' +
  '<input type="radio" name="item-type" id="item-ono">' +
  '<span></span>' +
  'ONO' +
  '</label>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="card-type">' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">State<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Country" id="state" class="form-control checkvalidity" required>' +
  '<option value="">Select</option>' +
  '<option value="2">State</option>' +
  '</select>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Suburb<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Country" id="suburb" class="form-control checkvalidity" required>' +
  '<option value="">Select</option>' +
  '<option value="2">Suburb</option>' +
  '</select>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">PIC</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<div class="d-flex flex-column">' +
  '<input type="text" placeholder="PIC Number" class="form-control">' +
  '<span class="text-orange field-info">Enter your PIC (Property Identification Code) here</span>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="card-type">' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Title<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-10">' +
  '<input type="text" placeholder="Title of Ad" class="form-control checkvalidity" required name="Title">' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Description<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-10">' +
  '<textarea name="Description" id="" cols="30" rows="5" placeholder="Description of Ad" class="form-control checkvalidity" required></textarea>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="card-type">' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Brand</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<input type="text" placeholder="Name" class="form-control">' +
  '</div>' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Model</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<input type="text" placeholder="Registration No." class="form-control">' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="card-type">' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Type</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Country" id="Type" class="form-control">' +
  '<option value="">Select</option>' +
  '<option value="2">Type</option>' +
  '</select>' +
  '</div>' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Condition</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="condition" id="condition" class="form-control">' +
  '<option value="">Select</option>' +
  '<option value="2">condition</option>' +
  '</select>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">category</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="category" id="category" class="form-control">' +
  '<option value="">Select</option>' +
  '<option value="2">category</option>' +
  '</select>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="step-actions">' +
  '<button class="btn btn-secondary previous-step" type="button">Prev</button>' +
  '<button class="btn btn-primary next-step" type="button">Next</button>' +
  '</div>';
var listingTypeProperty = '<div class="card-type">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Price<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<div class="d-flex flex-column">' +
  '<input type="text" class="form-control checkvalidity" placeholder="Enter Price" required name="price">' +
  '<span class="text-orange field-info">Enter price in numbers only (eg. 100 or 1000 or 10000)<br>Do not use full stops or commas (eg. 1,000 or 100.00)</span>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '</div>' +
  '<div class="col col-md-6 pl-5">' +
  '<div class="d-flex mt-2">' +
  '<label for="" class="mb-0 mr-3">Item show type</label>' +
  '<div class="d-flex">' +
  '<label for="item-free" class="custom-radio mr-3 mb-0">' +
  '<input type="radio" name="item-type" id="item-free">' +
  '<span></span>' +
  'Free' +
  '</label>' +
  '</div>' +
  '</label>' +
  '<label for="item-negotiable" class="custom-radio mr-3 mb-0">' +
  '<input type="radio" name="item-type" id="item-negotiable" checked>' +
  '<span></span>' +
  'Negotiable' +
  '</label>' +
  '<label for="item-ono" class="custom-radio mr-3 mb-0">' +
  '<input type="radio" name="item-type" id="item-ono">' +
  '<span></span>' +
  'ONO' +
  '</label>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="card-type">' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">State<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Country" id="state" class="form-control checkvalidity" required>' +
  '<option value="">Select</option>' +
  '<option value="2">State</option>' +
  '</select>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Suburb<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Country" id="suburb" class="form-control checkvalidity" required>' +
  '<option value="">Select</option>' +
  '<option value="2">Suburb</option>' +
  '</select>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">PIC</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<div class="d-flex flex-column">' +
  '<input type="text" placeholder="PIC Number" class="form-control">' +
  '<span class="text-orange field-info">Enter your PIC (Property Identification Code) here</span>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="card-type">' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Title<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-10">' +
  '<input type="text" placeholder="Title of Ad" class="form-control checkvalidity" required>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Description<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-10">' +
  '<textarea name="" id="" cols="30" rows="5" placeholder="Description of Ad" class="form-control checkvalidity" required></textarea>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="card-type">' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Land Size</label>' +
  '</div>' +
  '<div class="col col-md-10">' +
  '<input type="text" placeholder="Name" class="form-control">' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="card-type">' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Property Category</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Country" id="Type" class="form-control">' +
  '<option value="">Select</option>' +
  '<option value="2">property category</option>' +
  '</select>' +
  '</div>' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">No. of Bathrooms</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="bathrooms" id="bathrooms" class="form-control">' +
  '<option value="">Select</option>' +
  '<option value="2">2</option>' +
  '</select>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">No. of Bedrooms</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Bedrooms" id="Bedrooms" class="form-control">' +
  '<option value="">Select</option>' +
  '<option value="2">2</option>' +
  '</select>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="step-actions">' +
  '<button class="btn btn-secondary previous-step" type="button">Prev</button>' +
  '<button class="btn btn-primary next-step" type="button">Next</button>' +
  '</div>';
var listingTypeTransport = '<div class="card-type">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Price<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<div class="d-flex flex-column">' +
  '<input type="text" class="form-control checkvalidity" placeholder="Enter Price" required name="Price">' +
  '<span class="text-orange field-info">Enter price in numbers only (eg. 100 or 1000 or 10000)<br>Do not use full stops or commas (eg. 1,000 or 100.00)</span>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '</div>' +
  '<div class="col col-md-6 pl-5">' +
  '<div class="d-flex mt-2">' +
  '<label for="" class="mb-0 mr-3">Item show type</label>' +
  '<div class="d-flex">' +
  '<label for="item-free" class="custom-radio mr-3 mb-0">' +
  '<input type="radio" name="item-type" id="item-free">' +
  '<span></span>' +
  'Free' +
  '</label>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="card-type">' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">State<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Country" id="state" class="form-control checkvalidity" required>' +
  '<option value="">Select</option>' +
  '<option value="2">State</option>' +
  '</select>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Suburb<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Country" id="suburb" class="form-control checkvalidity" required>' +
  '<option value="">Select</option>' +
  '<option value="2">Suburb</option>' +
  '</select>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">PIC</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<div class="d-flex flex-column">' +
  '<input type="text" placeholder="PIC Number" class="form-control">' +
  '<span class="text-orange field-info">Enter your PIC (Property Identification Code) here</span>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="card-type">' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Title<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-10">' +
  '<input type="text" placeholder="Title of Ad" class="form-control checkvalidity" required name="Title">' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Description<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-10">' +
  '<textarea name="description" id="" cols="30" rows="5" placeholder="Description of Ad" class="form-control checkvalidity"></textarea>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="card-type">' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Make</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<input type="text" placeholder="Name" class="form-control">' +
  '</div>' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Model</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<input type="text" placeholder="Registration No." class="form-control">' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Year</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<input type="text" placeholder="2002" class="form-control">' +
  '</div>' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">KMS</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<input type="text" placeholder="10000" class="form-control">' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="card-type">' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Type<span class="text-orange">*</span></label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Country" id="Type" class="form-control checkvalidity" required>' +
  '<option value="">Select</option>' +
  '<option value="2">Type</option>' +
  '</select>' +
  '<span class="errorMessage"></span>' +
  '</div>' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Axles</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Axles" id="Axles" class="form-control">' +
  '<option value="">Select</option>' +
  '<option value="2">Axles</option>' +
  '</select>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">No. of Horses to carry</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="Breed" id="breed" class="form-control">' +
  '<option value="">Select</option>' +
  '<option value="1">1</option>' +
  '<option value="2">2</option>' +
  '</select>' +
  '</div>' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Registration state</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="reg-state" id="rider" class="form-control">' +
  '<option value="">Select</option>' +
  '<option value="2">Registration State</option>' +
  '</select>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="form-group">' +
  '<div class="row">' +
  '<div class="col col-md-2 pr-0">' +
  '<label for="" class="mb-0 mt-2 float-right text-right">Ramp location</label>' +
  '</div>' +
  '<div class="col col-md-4">' +
  '<select name="ramp-location" id="ramp-location" class="form-control">' +
  '<option value="">Select</option>' +
  '<option value="2">Ramp location</option>' +
  '</select>' +
  '</div>' +
  '<div class="col col-md-2 pr-md-0">' +
  '<label for="" class="mb-md-0 mt-md-2 float-md-right text-md-right text-transform-none">Vehicle registration number</label>' +
  '</div>' +
  '<div class="col col-md-4 mb-3 mb-md-0">' +
  '<input type="text" placeholder="Vehicle registration number" class="form-control">' +
  '</div>' +
  '</div>' +
  '</div>' +
  '</div>' +
  '<div class="step-actions">' +
  '<button class="btn btn-secondary previous-step" type="button">Prev</button>' +
  '<button class="btn btn-primary next-step" type="button">Next</button>' +
  '</div>';
$(function () {

  category_field_validation();

  $("select").select2({
    minimumResultsForSearch: -1,
  });
  $(".collapse-icon").on("click", function (e) {
    e.stopPropagation();
    e.preventDefault();
    $("body").toggleClass("sidenav-collapsed");
    $(this).toggleClass("flip");
    $(".brand-logo").find("img.main").toggleClass("d-none");
    $(".leftColumn").find("ul").toggleClass("collapsed-list");
    if ($("ul.collapsed-list").length) {
      var subMenuTrigger = $("ul.collapsed-list .has-submenu > a.opened");
      subMenuTrigger.next().slideToggle(function () {
        subMenuTrigger.removeClass("opened");
      });
    } else {
      console.log("Open currently opened");
      currentlyOpened.next().slideToggle(function () {
        currentlyOpened.addClass("opened");
      });
    }
  });
  $("table.listing-table").each(function () {
    var dragID = $(this).find("tbody").attr("id");
    if (dragID) {
      draggableList(dragID);
    }
    var selectedItem = 0;
    $(this).find("label.custom-checkbox input").on("change", function () {
      if ($(this).prop("checked") == true) {
        selectedItem++;
      } else {
        selectedItem--;
      }
      if (selectedItem > 0) {
        $(this).closest(".table").find("button.btn-secondary").removeAttr("disabled");
      } else {
        $(this).closest(".table").find("button.btn-secondary").attr("disabled", "disabled");
      }
    });
  });
  $(document).on("click", "li.has-submenu > a", function (e) {
    var subMenuTrigger = $(this);
    e.stopPropagation();
    e.preventDefault();
    subMenuTrigger.next().slideToggle(function () {
      subMenuTrigger.toggleClass("opened");
    });
  });
  if ($(".formValidate").length) {
    $(".formValidate").validate({
      rules: {
        name: {
          required: true
        },
        email: {
          required: true,
          email: true
        },
        number: {
          required: true
        },
      },
      errorElement: 'div',
      errorPlacement: function (error, element) {
        var placement = $(element).parent().find('.errorMessage');
        if (placement) {
          $(placement).append(error)
        } else {
          error.insertAfter(element);
        }
      },
      submitHandler: function (form) {
        alert("Form submitted");
      }
    });
  }
  if ($("#editor").length) {
    var editor = new Quill('#editor', {
      modules: {
        'formula': true,
        'syntax': true,
        'toolbar': [
          [{
            'header': '1'
          },
            {
              'header': '2'
            }
          ],
          ['bold', 'italic', 'underline'],          
          [{
            'size': []
          }],
          [{
            'list': 'ordered'
          }, {
            'list': 'bullet'
          }, {
            'indent': '-1'
          }, {
            'indent': '+1'
          }],
          ['direction', {
            'align': []
          }]
        ],
      },
      theme: 'snow',
    });
    editor.on('text-change', function(delta, oldDelta, source) {      
      document.getElementById("detailed_text").value = editor.root.innerHTML;
    });
    editor.container.firstChild.innerHTML = $('#detailed_text').val();    
  }
  if ($('#chart').length) {
    initBarChart = $('#chart').barChart(chartOptions);
    $(".bar-chart .bar-line").each(function () {
      var value = $(this).attr("data-value");
      if (value < 5000) {
        $(this).css("background-color", "#D2D2D2");
      } else if (value < 10000) {
        $(this).css("background-color", "#A4A2A2");
      } else if (value < 50000) {
        $(this).css("background-color", "#646464");
      } else {
        $(this).css("background-color", "#3F3F3F");
      }
    })
  }
  if ($('#dashboardChart').length) {
    initBarChart = $('#dashboardChart').barChart(chartOptionsDashboard);
    $(".bar-chart .bar-line").each(function () {
      var value = $(this).attr("data-value");
      if (value < 3000) {
        $(this).css("background-color", "#D2D2D2");
      } else if (value < 7500) {
        $(this).css("background-color", "#A4A2A2");
      } else if (value < 10000) {
        $(this).css("background-color", "#646464");
      } else {
        $(this).css("background-color", "#3F3F3F");
      }
    })
  }
  if ($("#pieChart").length) {
    const ctx = document.getElementById('pieChart').getContext('2d');
    const myChart = new Chart(ctx, {
      plugins: [ChartDataLabels],
      type: 'pie',
      data: {
        labels: ["59%", "41%"],
        datasets: [{
          data: [59, 41],
          labels: false,
          backgroundColor: [
            '#B9FF8E',
            '#FF9D9D',
          ],
          hoverBackgroundColor: [
            '#B9FF8E',
            '#FF9D9D',
          ],
          borderWidth: 0
        }]
      },
      options: {
        plugins: {
          // Change options for ALL labels of THIS CHART
          datalabels: {
            color: ['#27530C', '#611717'],
            formatter: function (value, context) {
              return context.chart.data.labels[context.dataIndex];
            },
            align: 'center',
            font: {
              size: 24,
              weight: 400
            }
          },
          legend: {
            display: false
          },
          tooltip: {
            enabled: false,
          },
          hover: {mode: null},
        },
        scales: {
          x: {
            grid: {
              display: false,
              borderWidth: 0
            },
            ticks: {
              display: false
            }
          },
          y: {
            grid: {
              display: false,
              borderWidth: 0
            },
            ticks: {
              display: false
            }
          }
        }
      }
    });
  }
  if ($("#pieChartUser").length) {
    const ctx = document.getElementById('pieChartUser').getContext('2d');
    const myChart = new Chart(ctx, {
      plugins: [ChartDataLabels],
      type: 'pie',
      data: {
        labels: ["59%", "41%"],
        datasets: [{
          data: [59, 41],
          labels: false,
          backgroundColor: [
            '#B9FF8E',
            '#FDFFB2',
          ],
          hoverBackgroundColor: [
            '#B9FF8E',
            '#FDFFB2',
          ],
          borderWidth: 0
        }]
      },
      options: {
        plugins: {
          // Change options for ALL labels of THIS CHART
          datalabels: {
            color: ['#27530C', '#9A5708'],
            formatter: function (value, context) {
              return context.chart.data.labels[context.dataIndex];
            },
            align: 'center',
            font: {
              size: 24,
              weight: 400
            }
          },
          legend: {
            display: false
          },
          tooltip: {
            enabled: false,
          },
          hover: {mode: null},
        },
        scales: {
          x: {
            grid: {
              display: false,
              borderWidth: 0
            },
            ticks: {
              display: false
            }
          },
          y: {
            grid: {
              display: false,
              borderWidth: 0
            },
            ticks: {
              display: false
            }
          }
        }
      }
    });
  }
  if ($("#dashboardChart2").length) {
    const ctx2 = document.getElementById('dashboardChart2').getContext('2d');
    const myChart = new Chart(ctx2, {
      type: 'bar',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
          data: [1000, 6000, 11000, 15000, 1000, 6000, 11000, 15000, 1000, 6000, 11000, 15000],
          backgroundColor: [
            '#D2D2D2',
            '#A4A2A2',
            '#3F3F3F',
            '#D2D2D2',
            '#A4A2A2',
            '#646464',
            '#A4A2A2',
            '#D2D2D2',
            '#646464',
            '#3F3F3F',
            '#A4A2A2',
            '#646464',
          ],
          borderWidth: 0,
          barThickness: 5,
          borderRadius: 7
        }]
      },
      options: {
        plugins: {
          legend: {
            display: false,
          },
          tooltip: {
            enabled: false
          },
          hover: {mode: null},
        },
        scales: {
          y: {
            beginAtZero: true,
            grid: {
              display: false,
              drawBorder: false
            }
          },
          x: {
            grid: {
              display: false,
              drawBorder: false
            }
          }
        }
      }
    });
  }
  if ($("table.table td.message").length) {
    dashboardTrim();
  }
  $(window).on("resize", function () {
    dashboardTrim();
  });
  $('[data-toggle="tooltip"]').tooltip()
  $(".postCategory input").each(function () {
    $(this).change(function () {
      var categoryType = $(this).closest("label").attr("for").replace("cat-", '');
      switch (categoryType) {
        case 'transport':
          $(".adDetailsStep").html(listingTypeTransport);
          break;
        case 'property':
          $(".adDetailsStep").html(listingTypeProperty);
          break;
        case 'saddlery':
          $(".adDetailsStep").html(listingTypeSaddlery);
          break;
        default:
          $(".adDetailsStep").html(listingTypeHorses);
      }
      $(".adDetailsStep").find("select").select2({
        minimumResultsForSearch: -1,
      })
    });
  });

  var drop = $("#postAdImages");
  drop.on('dragenter', function (e) {
    $(".dropzone").css({
      "border": "4px dashed #09f",
      "background": "rgba(0, 153, 255, .05)"
    });
    $(".cont").css({
      "color": "#09f"
    });
  }).on('dragleave dragend mouseout drop', function (e) {
    $(".drop").css({
      "border": "3px dashed #DADFE3",
      "background": "transparent"
    });
    $(".cont").css({
      "color": "#8E99A5"
    });
  });


  function handleFileSelect(evt) {
    var files = evt.target.files; // FileList object

    // Loop through the FileList and render image files as thumbnails.
    for (var i = 0, f; f = files[i]; i++) {
      postImAages.push(files[i]);
      // Only process image files.
      if (!f.type.match('image.*')) {
        swal({
          title: "Invalid image",
          text: "Please upload valid image [Only .png .gif .jpg .jpeg types are allowed].",
          icon: "warning",
          buttons: {
            cancel: {
              text: "Cancel",
              value: null,
              visible: true,
              className: "btn btn-secondary",
              closeModal: true
            },
            confirm: {
              text: "OK",
              value: true,
              visible: true,
              className: "btn btn-primary",
              closeModal: true
            }
          }
        })
        return false
      }

      var reader = new FileReader();

      // Closure to capture the file information.
      reader.onload = (function (theFile) {


        return function (e) {
          // Render thumbnail.
          var image = new Image();
          image.src = e.target.result;

          image.onload = function () {
            $(".dropzone-text").addClass("d-none");
            $(".add-more-image").remove();
            var span = document.createElement('span');
            span.innerHTML = ['<a class="icon red-trash removeImage" title="Remove Image"></a><img class="thumb img-fluid" src="', e.target.result,
              '" title="', escape(theFile.name), '"/>'
            ].join('');
            document.getElementById('list').insertBefore(span, null);
            $("#list").append("<span class='add-more-image'>Add images<span class=\"text-orange field-info\">\n" +
              "                          Files must be less than <strong>20 MB</strong><br>Allowed file types: <strong>.png .gif .jpg .jpeg</strong><br>Recommended image size: <strong>800x600 px</strong>\n" +
              "                        </span></span>");
          };
        };
      })(f);

      // Read in the image file as a data URL.
      reader.readAsDataURL(f);
    }
  }

  $('#postAdImages').change(handleFileSelect);
  $(document).on("click", ".removeImage", function () {
    $(this).closest("span").remove();
  });
  $(document).on("click", ".add-more-image", function () {
    $('#postAdImages').trigger("click");
  });
  if ($('.adminSwal').length) {
    $('.adminSwal').click(function () {
      var swalText = $(this).attr('data-swalText');
      var swalTitle = $(this).attr('dataSwalTitle');
      swal({
        title: swalTitle,
        text: swalText,
        icon: "warning",
        buttons: {
          cancel: {
            text: "Cancel",
            value: null,
            visible: true,
            className: "btn btn-secondary",
            closeModal: true
          },
          confirm: {
            text: "OK",
            value: true,
            visible: true,
            className: "btn btn-primary",
            closeModal: true
          }
        }
      })
    });
  }
});

function draggableList(item) {
  tableList = document.getElementById(item);
  Sortable.create(tableList, {
    handle: '.table-drag',
    animation: 150
  });
}

function dashboardTrim() {
  var msgWidth = 0;
  $("p.dashboard-message").css("width", msgWidth + "px");
  $("table.table td.message").each(function () {
    if (msgWidth < $(this).width()) {
      msgWidth = $(this).width();
    }
    $("p.dashboard-message").css("width", msgWidth + "px");
  });
}

function category_field_validation() {
  if ($("#linearStepper").length) {
    var linearStepper = document.querySelector('#linearStepper');
    var linearStepperInstace = new MStepper(linearStepper, {
      firstActive: 0,
      showFeedbackPreloader: true,
      // Auto generation of a form around the stepper.
      autoFormCreation: true,
      // Function to be called everytime a nextstep occurs. It receives 2 arguments, in this sequece: stepperForm, activeStepContent.
      validationFunction: defaultValidationFunction, // more about this default functions below
      // Enable or disable navigation by clicking on step-titles
      stepTitleNavigation: false,
      feedbackPreloader: '<div class="spinner-layer spinner-blue-only">...</div>'
    });

    linearStepperInstace.resetStepper();

    $(document).on("click", ".adDetailsStep .next-step", function () {
      linearStepperInstace.nextStep();
    });
    $(document).on("click", ".adDetailsStep .previous-step", function () {
      linearStepperInstace.prevStep();
    });

    function defaultValidationFunction(stepperForm, activeStepContent) {
      var returnCnt = true;
      var inputs = activeStepContent.querySelectorAll('.checkvalidity');
      if (inputs.length > 0) {
        for (let i = 0; i < inputs.length; i++) {
          var characterReg = /^[a-zA-Z0-9][\sa-zA-Z0-9]*/;
          if (!$(inputs[i]).val()) {
            $(inputs[i]).addClass("hasError");
            $(inputs[i]).parent().find(".errorMessage").html("This is required field");
            returnCnt = false;
          } else if (!characterReg.test($(inputs[i]).val())) {
            $(inputs[i]).parent().find(".errorMessage").html("Please enter valid data");
            returnCnt = false;
          } else {
            $(inputs[i]).removeClass("hasError");
            $(inputs[i]).parent().find(".errorMessage").html("");
          }
        }
      }
      // for (let i = 0; i < inputs.length; i++) {
      //   if (!inputs[i].checkValidity()) {
      //     $(inputs[i]).addClass("haserror");
      //     $(inputs[i]).parent().find('.errorMessage').html('This field is required!');
      //     // $("html,body").animate({ scrollTop: $(".haserror:first").offset().top - 50 }, 500)
      //     returnCnt = false;
      //   } else {
      //     $(inputs[i]).removeClass("haserror");
      //     $(inputs[i]).parent().find('.errorMessage').html('');
      //   }
      // }
      if (returnCnt) {
        return true;
      } else {
        return false
      }
    }
  }
  if ($("#wizard").length) {
    var linearStepper = document.querySelector('#wizard');
    var linearStepperInstace = new MStepper(wizard, {
      firstActive: 0,
      showFeedbackPreloader: true,
      // Auto generation of a form around the stepper.
      autoFormCreation: true,
      // Function to be called everytime a nextstep occurs. It receives 2 arguments, in this sequece: stepperForm, activeStepContent.
      validationFunction: defaultValidationFunction, // more about this default functions below
      // Enable or disable navigation by clicking on step-titles
      stepTitleNavigation: false,
      feedbackPreloader: '<div class="spinner-layer spinner-blue-only">...</div>'
    });

    linearStepperInstace.resetStepper();

    function defaultValidationFunction(stepperForm, activeStepContent) {
      var returnCnt = true;
      var inputs = activeStepContent.querySelectorAll('.checkvalidity');
      for (let i = 0; i < inputs.length; i++) {
        if (!inputs[i].checkValidity()) {
          $(inputs[i]).addClass("error");
          $(inputs[i]).parent().find('.errorMessage').html('This field is required!');
          returnCnt = false;
        } else {
          $(inputs[i]).parent().find('.errorMessage').html('');
        }
      }
      if (returnCnt) {
        return true;
      } else {
        return false
      }
    }
  }
}