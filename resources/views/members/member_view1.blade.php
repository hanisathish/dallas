let cardBlock = $('div');
            let cardHeader = $('div');
            let cardBody = $('div');
            cardBlock.id = 'household-card'+index;
            cardBlock.addClass('card');
            cardHeader.addClass('card-header');
            cardBody.addClass('card-body');
            let cardHeaderInner = `<h6> ${item.name}  
                                    <span class="float-right" onClick="openHouseholdModalWithId(${item.id})">
                                        <i class="fa fa-edit"></i>
                                    </span>
                                </h6>`;
            cardHeader.append(cardHeaderInner);
            cardBlock.append(cardHeader);

            item.users.forEach(function(userItem, index){
                console.log(`Item: ${JSON.stringify(userItem)}`);
                let userEl = `<p id="${'user-block'+userItem.id}"><i class="fa fa-user"></i> 
                    <a href="${user.id === userItem.id? '#' : '/people/member/'+ personal_id}" >
                        ${userItem.first_name} 
                        ${userItem.middle_name ?', ' +userItem.middle_name : ''}
                        ${userItem.last_name ?', ' +userItem.last_name : ''}
                    </a>
                    ${userItem.isPrimary === 1? '<i class="fa fa-star></i>' : '' } 
                </p>`;
                cardBody.append(userEl)
            })
            cardBlock.append(cardBody);
            $("#household-blocks").append(cardBlock);