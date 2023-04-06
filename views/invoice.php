<? //php require_once("includes/links.php");
?>

<style>
  .modal-body {
    color: black;
  }

  .clr-timeline.clr-timeline-vertical {
    flex-direction: column;
    min-width: 16rem;
  }

  .clr-timeline {
    display: flex;
    padding: 0.6rem;
  }

  .clr-timeline.clr-timeline-vertical .clr-timeline-step:not(:last-of-type) {
    margin-bottom: 1.8rem;
  }

  .clr-timeline.clr-timeline-vertical .clr-timeline-step {
    flex-direction: row;
    margin-left: 0;
    position: relative;
  }

  .clr-timeline-step cds-icon,
  .clr-timeline-step clr-icon {
    height: 1.8rem;
    width: 1.8rem;
    min-height: 1.8rem;
    min-width: 1.8rem;
  }

  .clr-timeline.clr-timeline-vertical .clr-timeline-step-body {
    display: flex;
    flex-direction: column;
    min-width: 8.9rem;
    margin-left: 0.6rem;
    margin-top: 0.3rem;
  }

  .clr-timeline.clr-timeline-vertical .clr-timeline-step:not(:last-of-type) .clr-timeline-step-body::before {
    position: absolute;
    width: 0.1rem;
    height: calc(100% + 0.2rem);
    transform: translate(-1.55rem, 1.4rem);
  }

  .clr-timeline.clr-timeline-vertical .clr-timeline-step-title {
    margin-top: 0;
  }

  .clr-timeline-step-title {
    color: #666;

    font-size: .65rem;
    font-weight: 500;

    line-height: .9rem;
    margin-top: 0.4rem;
    margin-bottom: 0.3rem;
  }

  .clr-timeline-step:not(:last-of-type) .clr-timeline-step-body::before {
    content: "";
    background: #b3b3b3;

    height: 0.1rem;
    width: calc(100% - 0.9rem - 0.1rem);
    transform: translate(1.7rem, -0.95rem);
  }

  .clr-timeline-step-description {
    color: #666;

    font-size: .55rem;
    line-height: .8rem;
  }

  .clr-timeline.clr-timeline-vertical .clr-timeline-step-header {
    text-align: right;
    white-space: normal;
    word-break: break-word;
    width: 3rem;
    min-width: 3rem;
    margin-right: 0.6rem;
    margin-top: 0.3rem;
    margin-bottom: 0;
  }

  .clr-timeline-step-header {
    color: #8c8c8c;
    font-size: .65rem;
    line-height: .9rem;
    white-space: nowrap;
    margin-bottom: 0.4rem;
  }

  .clr-timeline-step {
    display: flex;
    flex-direction: column;
    width: 100%;
    min-width: 8.75rem;
    margin-left: 0.6rem;
  }

  div#search-inner {
    top: 0;
    height: 100vh;
    overflow: auto;
    width: 100vw;
    max-width: unset;
  }

  .waybil-container figure {
    width: 100%;
    margin: 0 auto;
    height: 200px;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  clr-icon {
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
  }

  .waybil-container h2 {
    text-align: center;
    font-size: 1.5em;
    font-weight: 700;
    margin-top: -32px;
  }

  .waybil-container .component {
    text-align: center;
  }

  .waybil-container .component h5 {
    font-weight: 700;
    font-size: 1.2rem;
    text-decoration: underline;
    text-transform: uppercase;
    text-rendering: optimizeLegibility;
    letter-spacing: 1px;
    font-family: system-ui;
  }
</style>


<div id="waybill" class="waybil-container">
  <div class="modal-dialog">
    <div class="modal-content modal-md">
      <!-- <div class="modal-header">
        <button type="button" onclick="closeModal()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div> -->
      <div class="modal-body">
        <?php
        $post = object($_GET);
        if (empty($post->tracking_number)) die("Tracking Number not found");

        $waybills = $generic->getFromTable("waybill", "tracking_number={$post->tracking_number}, status=1");
        if (empty($waybills)) die("Tracking Number Invalid");

        $waybill = reset($waybills);

        $users = $generic->getFromTable("users", "id IN ('$waybill->sender','$waybill->receipient')");
        $users = array_remap($users, array_column($users, "id"));

        $sender = $users[$waybill->sender];
        $receipient = $users[$waybill->receipient];

        $tracking = $generic->getFromTable("tracking", "waybill_id={$waybill->id}");

        $cargo_type = $paramControl->load_sources("cargo_type");
        $tracking_status = $paramControl->load_sources("tracking_status");
        $tracking_message = $paramControl->load_sources("tracking_message");
        $countries = $paramControl->load_sources("countries");
        ?>
        <div class="row">
          <div class="col-s12">
            <figure>
              <img src="<?= $uri->site ?>images/barcode.jpeg" alt="" srcset="">
            </figure>
          </div>
          <div class="col-s12">
            <h2 cds-text><?= strtoupper($waybill->tracking_number) ?></h2>
          </div>
        </div>
        <div class="row">
          <div class="col-md-6">
            <div class="component">
              <h5>Sender</h5>
              <p>
                <strong><?= $sender->first_name ?> <?= $sender->last_name ?></strong>
                <br>
                <span><?= $sender->address ?></span>
                <br>
                <span><?= $sender->phone ?></span>
                <br>
                <span><?= $sender->email ?></span>
              </p>
            </div>
          </div>
          <div class="col-md-6">
            <div class="component">
              <h5>Receipient</h5>
              <p>
                <strong><?= $receipient->first_name ?> <?= $receipient->last_name ?></strong>
                <br>
                <span><?= $receipient->address ?></span>
                <br>
                <span><?= $receipient->phone ?></span>
                <br>
                <span><?= $receipient->email ?></span>
              </p>
            </div>
          </div>
          <div class="col-md-12">
            <div class="component">
              <h5>Waybill Info</h5>
              <p><?= $waybill->parcel_title ?></p>
              <div class="responsive-table">
                <table class="table">
                  <tbody>
                    <tr>
                      <th>Weight</th>
                      <td><?= $waybill->parcel_weight ?> KG</td>
                    </tr>
                    <tr>
                      <th>Cargo Type</th>
                      <td><?= $cargo_type->{$waybill->cargo_type} ?> KG</td>
                    </tr>
                    <tr>
                      <th>Parcel Charged</th>
                      <td><?= $currency . $fmn->format($waybill->parcel_charge) ?></td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-12 mt-5">
            <div class="component">
              <h5>Tracking Information</h5>
            </div>
            <ul class="clr-timeline clr-timeline-vertical ">
              <?php
              $icons = ["success" => "check-circle", "danger" => "ban", "warning" => "exclamation-circle"];
              foreach ($tracking as $key => $value) { ?>
                <?php
                $date = new DateTime($value->date_created);
                $message = $tracking_message->{$value->tracking_message};
                $message = str_replace("[TYPE]", $cargo_type->{$waybill->cargo_type}, $message);
                $message = str_replace("[STATUS]", $tracking_status->{$value->status}, $message);
                $message = str_replace("[ADDRESS]", $countries->{$receipient->country}, $message);
                ?>
                <li class="clr-timeline-step">
                  <div class="clr-timeline-step-header"><?= $date->format("jS M-y, h:i:a") ?></div>
                  <clr-icon shape="circle" aria-label="Not started">
                    <i class="fa fa-<?= $icons[$value->status] ?> text-<?= $value->status ?>"></i>
                  </clr-icon>
                  <div class="clr-timeline-step-body">
                    <span class="clr-timeline-step-title"><?= $tracking_status->{$value->status} ?></span>
                    <span class="clr-timeline-step-description"><?= $message ?></span>
                  </div>
                </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>