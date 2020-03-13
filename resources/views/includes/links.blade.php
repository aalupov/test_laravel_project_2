<ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" href="{{ route('orders.index') }}">All</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('overdueOrders') }}">Overdue</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{ route('currentOrders') }}">Current</a>
  </li>
  <li class="nav-item">
    <a class="nav-link disabled" href="{{ route('newOrders') }}">New</a>
  </li>
  <li class="nav-item">
    <a class="nav-link disabled" href="{{ route('completedOrders') }}">Completed</a>
  </li>  
</ul>