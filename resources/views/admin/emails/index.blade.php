  <!DOCTYPE html>
  <html lang="en">

  <head>
      <meta charset="utf-8">


      <title>modern Gmail inbox - Bootdey.com</title>
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="https://netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css" rel="stylesheet">
      <style type="text/css">
          /* CSS used here will be applied after bootstrap.css */
          body {
              margin-top: 50px;
          }

          .nav-tabs .glyphicon:not(.no-margin) {
              margin-right: 10px;
          }

          .tab-pane .list-group-item:first-child {
              border-top-right-radius: 0px;
              border-top-left-radius: 0px;
          }

          .tab-pane .list-group-item:last-child {
              border-bottom-right-radius: 0px;
              border-bottom-left-radius: 0px;
          }

          .tab-pane .list-group .checkbox {
              display: inline-block;
              margin: 0px;
          }

          .tab-pane .list-group input[type="checkbox"] {
              margin-top: 2px;
          }

          .tab-pane .list-group .glyphicon {
              margin-right: 5px;
          }

          .tab-pane .list-group .glyphicon:hover {
              color: #FFBC00;
          }

          a.list-group-item.read {
              color: #222;
              background-color: #F3F3F3;
          }

          hr {
              margin-top: 5px;
              margin-bottom: 10px;
          }

          .nav-pills>li>a {
              padding: 5px 10px;
          }

          .ad {
              padding: 5px;
              background: #F5F5F5;
              color: #222;
              font-size: 80%;
              border: 1px solid #E5E5E5;
          }

          .ad a.title {
              color: #15C;
              text-decoration: none;
              font-weight: bold;
              font-size: 110%;
          }

          .ad a.url {
              color: #093;
              text-decoration: none;
          }
      </style>
  </head>

  <body>
      <div class="container bootstrap snippets bootdey">
          <div class="row">
              <div class="col-sm-3 col-md-2">
                  <h3>inbox</h3>
              </div>
          </div>
          <hr>
          <div class="row">
              <div class="col-sm-9 col-md-10">
                  <div class="tab-content">
                      <div class="tab-pane fade in active" id="home">
                          <div class="list-group">
                              @forelse ($messagesWithAttachments as $message)
                                  <div class="border bg-danger panel-footer">
                                      @php
                                          $attachments = $message->getAttachments();
                                      @endphp
                                      <span href="#" class="border-secondary p-4">
                                          <span class="label label-success">{{ $message->getFrom()['email'] }}</span>
                                          @foreach ($attachments as $attachment)
                                              <a class="label label-primary"
                                                  href="{{ url(getAdminRoutePrefix()) . '/download/attachment/' .  $message->getId().'/'.$attachment->getId() }}">{{ $attachment->getFilename() }}</a>
                                          @endforeach
                                      </span>
                                  </div>
                              @empty
                                  <p>Sorry, no attachments available.</p>
                              @endforelse
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </body>

  </html>
