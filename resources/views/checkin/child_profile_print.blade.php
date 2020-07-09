<style>
    
    

  
</style>

<div class="container" id="profileBlockPrint">
    
    <table style="border: 1px solid #ccc; width: 100%">
        <tbody>
            <tr>
                <td style="width: 50%;">
                    <img src="{{$profileDetails->user_image}}" alt="" style="max-width:200px;"  class="img-rounded img-responsive child-img"  />
                </td>
                <td style="vertical-align: text-top;">
                    <span style="font-size:18px;font-weight: bold">
                        {{$profileDetails->full_name}} </span>
                        
                    <p style="font-size:16px;">
                            <i class="glyphicon glyphicon-envelope"></i>Contact No: {{$profileDetails->mobile}}
                            <br />
                          
                            <i class="glyphicon glyphicon-gift"></i>Event: {{$profileDetails->eventName}}
                        <br />
                        <img src="{{$profileDetails->qr_code}}" alt="" style="max-width:100px;"  class="img-rounded img-responsive child-img"  />
                        
                        </p>
                </td>
            </tr>
        </tbody>
    </table>
    
        </div>
    </div>
</div>