@if(!$data->isEmpty())

<ul class="timeline timeline-inverse">

    <!-- timeline time label -->

    <!-- <li class="time-label">

          <span class="bg-red">

            10 Feb. 2014

          </span>

    </li> -->

    <!-- /.timeline-label -->

    <!-- timeline item -->

    

    @foreach($data as $key => $value)

    <li>

      <i class="fa fa-envelope bg-blue"></i>

      <div class="timeline-item">

        <span class="time"><i class="fa fa-clock-o"></i> {{date("d/m/Y H:i:s",strtotime($value->created_at))}}</span>

        <h5 class="timeline-header"><span class="leaveMessageList"><strong class="text-success">Send by</strong> &nbsp;{{$value->sender->employee->fullname}}</span></h5>

        <div class="timeline-body">

          <span class="leaveMessageList"><strong class="text-danger">Received by</strong> &nbsp;{{$value->receiver->employee->fullname}}</span><br><br>

          {{$value->message}}

        </div>

        <!-- <div class="timeline-footer">

          <a class="btn btn-primary btn-xs">Read more</a>

          <a class="btn btn-danger btn-xs">Delete</a>

        </div> -->

      </div>

    </li>

    @endforeach

    <li>
      <i class="fa fa-clock-o bg-gray"></i>
    </li>

  </ul>

  @else
      <span class="text-danger"><strong>No message.</strong></span>
  @endif