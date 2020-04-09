<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv=X-UA-Compatible content="IE=Edge,chrome=1" />
    <meta name=viewport content="width=device-width,initial-scale=1.0,maximum-scale=1.0" />

    <title>Unit Elections Portal | Tulpe Lodge - Order of the Arrow, BSA</title>

    <link rel="stylesheet" href="libraries/bootstrap-4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="libraries/fontawesome-free-5.12.0/css/all.min.css">
    <link rel="stylesheet" href="libraries/fontawesome-free-5.12.1-web/css/all.min.css">
    <link rel="stylesheet" href="https://use.typekit.net/awb5aoh.css" media="all">
    <link rel="stylesheet" href="style.css">


</head>

<body class="d-flex flex-column h-100" id="section-conclave-report-form" data-spy="scroll" data-target="#scroll" data-offset="0">
  <div class="wrapper">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php">
            <img src="/assets/tulpe-signature_reversed.svg" alt="Tulpe Lodge" class="d-inline-block align-top">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-main">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse c-navbar-content" id="navbar-main">
            <div class="navbar-nav ml-auto">
                <a class="nav-item nav-link" href="https://tulpelodge.org" target="_blank">Tulpe Lodge Home</a>
            </div>
        </div>
    </nav>

    <main class="container-fluid flex-shrink-0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <div class="row">
            <div class="col-12">
                <section>
                    <?php
                    if ($_GET['error'] == 1) { ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> Something went wrong. Please try again. If this continues, please <a href="#" data-toggle="modal" data-target="#contact">contact the Lodge leadership team</a>.
                        <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                    </div>
                    <?php }
                    if ($_GET['contact'] == 1) { ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Thanks!</strong> Your contact form has been submitted, and we'll be in touch soon.
                        <button type="button" class="close" data-dismiss="alert"><i class="fas fa-times"></i></button>
                    </div>
                    <?php } ?>
                </section>
            </div>
        </div>

        <div class="alert alert-success" role="alert">
            <strong>Thanks!</strong> Your votes have been submitted!
        </div>
        <div class="row">
          <div class="col-12">
            <div class="card mb-3">
              <div class="card-body">
                <h3 class="card-title">Are you already a Lodge member?</h3>
                <div class="row">
                  <div class="col-md-8 mb-md-auto mb-3">
                    Don't forget to pay your 2020 Lodge Dues! Paying your dues is a simple and great way to stay engaged with the lodge and support its mission and programs!  In addition, you will receive the 2020 Commemorative Membership Flap!
                  </div>
                  <div class="col-md-4">
                    <a class="btn btn-primary btn-block" href="http://www.narragansettbsa.org/event/2020-oa-dues-enrollment/2600970" target="_blank">Pay Now!</a>
                  </div>
                </div>
                <hr></hr>
                <p class="card-text mb-0">
                  <strong>Seal Your Membership in the Order of the Arrow: Join us for the Brotherhood</strong>
                  <br>
                  Has it been more than 6 months since you successfully completed your Ordeal experience and became a member of the Order of the Arrow?  Join us for the Brotherhood.  This worthwhile experience, which is completely different than your Ordeal, is not to be missed.
                  <br></br>
                  Upon completing your Brotherhood Trail, you will receive:</p>
                  <ol class="mb-0">
                    <li>Brotherhood Sash</li>
                    <li>Certificate</li>
                    <li>Recognition Pin</li>
                  </ol>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card mb-3">
              <div class="card-body text-center">
                <h3 class="card-title">Stay Connected</h3>
                <p class="footer-socialmedia">
                  <a href="https://www.facebook.com/tulpelodge" target="_blank"><i class="fab fa-facebook-square fa-2x"></i></a>
                  <a href="https://twitter.com/tulpelodge" target="_blank"><i class="fab fa-twitter-square fa-2x"></i></a>
                  <a href="https://www.instagram.com/tulpelodge/" target="_blank"><i class="fab fa-instagram-square fa-2x"></i></a>
                </p>
              </div>
            </div>
            <div class="list-group mb-3">
              <a href="https://tulpelodge.org/sites/default/files/unit-relations/ActiveArrowman.pdf" class="list-group-item list-group-item-action" target="_blank">Active Arrowman Award</a>
              <a href="https://tulpelodge.org/sites/default/files/unit-relations/2020-Calendar.pdf" class="list-group-item list-group-item-action" target="_blank">2020 Lodge Calendar</a>
              <a href="https://tulpelodge.org/sites/default/files/unit-relations/LodgeEvents.pdf" class="list-group-item list-group-item-action" target="_blank">Lodge Events Flyer</a>
            </div>

            <a href="https://tulpelodge.org/events" target="_blank" class="btn btn-primary btn-block mb-3">Events Registration Portal</a>
          </div>

          <div class="col-md-9">
            <div class="card mb-3">
              <div class="card-body text-center">
                <h3 class="card-title">2019 Year in Review</h3>
                <div class="mt-3 col-10 mx-auto embed-responsive embed-responsive-16by9">
                  <video controls poster="/assets/yir-thumb.jpg">
                    <source src="/assets/TulpeYearInReview2019.mp4" type="video/mp4">
                    <div class="alert alert-danger" role="alert">Your browser does not support embedded video at this time. Please watch on Youtube here: <a class="alert-link" href="https://www.youtube.com/watch?v=uHOCArShiJc" target="_blank">https://www.youtube.com/watch?v=uHOCArShiJc</a></div>
                  </video>
              </div>
            </div>
          </div>

        </div>
      </main>
    </div>
      <?php include "footer.php"; ?>

      <script src="libraries/jquery-3.4.1.min.js"></script>
      <script src="libraries/popper-1.16.0.min.js"></script>
      <script src="libraries/bootstrap-4.4.1/js/bootstrap.min.js"></script>

      <div class="modal fade" id="contact" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                  <form id="contactForm" method="POST" action="contact-process.php">
                      <div class="modal-header">
                          <h5 class="modal-title">Contact the Lodge Leadership Team</h5>
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                      <div class="modal-body">
                          <p>If you encounter technical issues while submitting your Unit Election ballot, please let the Lodge Leadership team know!</p>
                          <div class="form-group mb-2">
                              <label class="required">Your Name</label>
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <label class="input-group-text"><i class="fas fa-fw fa-user"></i></label>
                                  </div>
                                  <input name="contact_name" id="contact-name" type="text" class="form-control" placeholder="Your Name" required>
                              </div>
                          </div>
                          <div class="form-group mb-2">
                              <label class="required">Your Email Address</label>
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <label class="input-group-text"><i class="fas fa-fw fa-envelope"></i></label>
                                  </div>
                                  <input name="contact_email" id="contact-email" type="email" class="form-control" placeholder="Your Email" required>
                              </div>
                          </div>
                          <div class="form-group mb-2">
                              <label>Your Unit</label>
                              <div class="input-group">
                                  <div class="input-group-prepend">
                                      <label class="input-group-text"><i class="fas fa-fw fa-sitemap"></i></label>
                                  </div>
                                  <input name="contact_unit" id="contact-unit" type="text" class="form-control" placeholder="Troop 1 Community" required value="<?php echo $unitInfo['unitNumber'] . " ". $unitInfo['unitCommunity']; ?>">
                              </div>
                          </div>
                          <div class="form-group">
                              <label class="required">Description</label>
                              <textarea name="contact_description" id="contact-description" class="form-control" rows="4" required placeholder="Please describe the issue. The more detail you provide, the easier it is for us to help you."></textarea>
                          </div>
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" name="contact_submit" value="submit" class="btn btn-primary">Send Message</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>

  </body>


  </html>
