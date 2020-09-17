<?php
                    $url_segment_one =  \Request::segment(1);
                    $url_segment_two =  \Request::segment(2);
                    $url_segment_three =  \Request::segment(3);
                    ?>
<div class="col-lg-3">
                        <div class="card m-b-30">
                            
                                <div class="card-body p-0">
                                  <ul class="nav nav-pills flex-column">
                                    <li @if($url_segment_one == "settings" && $url_segment_two == "sms" && $url_segment_three == "create_page") class='nav-item active' @else class='nav-item' @endif">
                                      <a href="{{asset('/settings/sms/create_page')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i> Compose SMS
                                      </a>
                                    </li>
                                    <li @if($url_segment_one == "settings" && $url_segment_two == "sms" && $url_segment_three == "") class='nav-item active' @else class='nav-item' @endif">
                                      <a href="{{asset('/settings/sms')}}" class="nav-link">
                                        <i class="fa fa-circle-o nav-icon"></i> Sent SMS
                                      </a>
                                    </li>
                                    
                                     
                                  </ul>
                                
                                 
                            </div>
                        </div>
                    </div>