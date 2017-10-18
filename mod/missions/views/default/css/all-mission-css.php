.mission-center-float-text
{
    position: absolute;
    z-index: -1;
    top: 50%;
    left: 50%;

    width: 512px;
    height: 128px;

    text-align: center;

    color: rgb(255,255,255);
    background-color: rgb(5,89,89);
}

.mission-center-float-text span
{
    vertical-align: middle;
}

#search-mission-simple-text-input::-webkit-input-placeholder
{
    opacity: .5 !important;
    color: #f00;
}

#search-mission-simple-text-input::-moz-placeholder
{
    opacity: .5;
    color: rgba(0,0,0,.5);
}

.missions-tab-bar
{
    width: auto;
    margin-bottom: 12px;
    padding: 15px 10px 0;

    border-style: solid;
    border-color: #047177;
    border-radius: 6px;
    background-color: #047177;
    box-shadow: 1px 1px 5px #ccc;
}

.missions-tab
{
    font-size: 18px;
    font-weight: bold;

    padding: 5px;

    color: white;;
    border-style: solid;
    border-color: #055959;
    border-radius: 6px;
    background-color: #055959;
}

.missions-tab a,
.missions-tab a:visited
{
    color: white;
}

.elgg-menu-mission-main a:visited,
.mission-link-color:visited
{
    color: #055959;
}

.mission-post-table
{
    table-layout: fixed;

    align: center;
}

.mission-post-table td
{
    padding-top: 4px;
    padding-bottom: 4px;
}

.mission-post-table-lefty
{
    width: 280px;
    padding-right: 6px;

    text-align: right;
}

.mission-post-table-righty
{
    width: 520px;

    text-align: left;
}

.mission-post-table-righty div
{
    width: 250px;
}

.mission-post-table-day
{
    display: inline-block;
}

.mission-post-table-day td
{
    padding: 4px;

    text-align: center;
}

.mission-post-table-day h3,
h4
{
    margin: 0;
    padding: 8px 2px;
}

.mission-printer
{
    position: relative;

    padding: 11px;

    border-width: 3px;
    border-style: none;
}

.mission-less
{
    display: inline-block;

    width: 100%;

    border-style: solid;
}

.mission-printer h5
{
    display: inline;
}

.mission-printer .elgg-button
{
    margin: 4px;

    vertical-align: middle;
}

.mission-gallery
{
    vertical-align: baseline;
}

.mission-gallery li
{
    padding: 10px;

    vertical-align: baseline;

    border-bottom: none;
}

.pagination
{
    position: relative;
    left: 40%;
}

.elgg-menu
{
    padding: 0 15px;
}

.mission-emphasis
{
    font-weight: bold;

    display: inline;
}

.mission-emphasis-extra
{
    font-size: 1.17em;
    font-weight: bold;

    display: block;
}

.mission-button-set
{
    bottom: 4px;

    width: 100%;

    text-align: center;
}

.mission-user-card-info
{
    bottom: 50px;

    width: 100%;
}

.mission-hr
{
    color: #af3c43;
    border-color: #af3c43;
    background-color: #af3c43;
}

li.link-disabled a
{
    cursor: default;
    pointer-events: none;
}

.mission-tab > li
{
    display: inline-block;

    text-align: center;
}

.mission-tab > li a
{
    border-bottom-color: rgb(227,227,227);
}

.tt-dropdown-menu
{
    width: 310px;
    padding: 8px 0;

    border: 1px solid #ccc;
    border: 1px solid rgba(0, 0, 0, .2);
    border-radius: 8px;
    background-color: #fff;
    box-shadow: 0 5px 10px rgba(0,0,0,.2);
}

.tt-suggestion
{
    font-size: 18px;
    line-height: 24px;

    padding: 3px 20px;
}



#mission-graph-spinner
{
    display: none;
}

/* ==========================================================
 * Spinner
 * =========================================================*/
.spinner
{
    position: relative;

    width: 100px;
    height: 100px;
    margin: 30px auto;

    -webkit-animation: rotateit 1.3s linear infinite;
       -moz-animation: rotateit 1.3s linear infinite;
            animation: rotateit 1.3s linear infinite;
}
@-webkit-keyframes rotateit
{
    from
    {
        -webkit-transform: rotate(360deg);
    }
    to
    {
        -webkit-transform: rotate(0deg);
    }
}
@-moz-keyframes rotateit
{
    from
    {
        -moz-transform: rotate(360deg);
    }
    to
    {
        -moz-transform: rotate(0deg);
    }
}
@keyframes rotateit
{
    from
    {
        transform: rotate(360deg);
    }
    to
    {
        transform: rotate(0deg);
    }
}
/*=======================================================
 * Circles
 *======================================================*/
.spinner.circles div
{
    position: absolute;
    top: 35px;
    left: 45px;

    width: 20px;
    height: 20px;

    border-radius: 50%;
    background: black;
}
.spinner.circles div:nth-child(1)
{
    -webkit-transform: rotate(0deg) translate(0, -35px) scale(1.4);
       -moz-transform: rotate(0deg) translate(0, -35px) scale(1.4);
            transform: rotate(0deg) translate(0, -35px) scale(1.4);
}
.spinner.circles div:nth-child(2)
{
    -webkit-transform: rotate(45deg) translate(0, -35px) scale(1.2);
       -moz-transform: rotate(45deg) translate(0, -35px) scale(1.2);
            transform: rotate(45deg) translate(0, -35px) scale(1.2);

    opacity: .7;
}
.spinner.circles div:nth-child(3)
{
    -webkit-transform: rotate(90deg) translate(0, -35px) scale(1.1);
       -moz-transform: rotate(90deg) translate(0, -35px) scale(1.1);
            transform: rotate(90deg) translate(0, -35px) scale(1.1);

    opacity: .6;
}
.spinner.circles div:nth-child(4)
{
    -webkit-transform: rotate(135deg) translate(0, -35px) scale(.9);
       -moz-transform: rotate(135deg) translate(0, -35px) scale(.9);
            transform: rotate(135deg) translate(0, -35px) scale(.9);

    opacity: .5;
}
.spinner.circles div:nth-child(5)
{
    -webkit-transform: rotate(180deg) translate(0, -35px) scale(.7);
       -moz-transform: rotate(180deg) translate(0, -35px) scale(.7);
            transform: rotate(180deg) translate(0, -35px) scale(.7);

    opacity: .4;
}
.spinner.circles div:nth-child(6)
{
    -webkit-transform: rotate(225deg) translate(0, -35px) scale(.5);
       -moz-transform: rotate(225deg) translate(0, -35px) scale(.5);
            transform: rotate(225deg) translate(0, -35px) scale(.5);

    opacity: .3;
}
.spinner.circles div:nth-child(7)
{
    -webkit-transform: rotate(270deg) translate(0, -35px) scale(.3);
       -moz-transform: rotate(270deg) translate(0, -35px) scale(.3);
            transform: rotate(270deg) translate(0, -35px) scale(.3);

    opacity: .2;
}
.spinner.circles div:nth-child(8)
{
    -webkit-transform: rotate(315deg) translate(0, -35px) scale(.1);
       -moz-transform: rotate(315deg) translate(0, -35px) scale(.1);
            transform: rotate(315deg) translate(0, -35px) scale(.1);

    opacity: .1;
}

/* Nick addin the styles yo - h8rs mad 'cause im stylin' on em**/

.mission-create-button
{
    margin-top: 60px;
}

.mission-info-card
{
    padding: 15px;
}

.caret-color
{
    color: #055252;
}

.mission-sort-panel
{
    padding: 4px;
}

.mission-card-footer
{
    position: absolute;
    bottom: 0;

    width: 100%;
}

.mission-card-body
{
    min-height: 450px;
}

.mission-details h5
{
    display: inline;
}

.mission-skills
{
    font-size: 14px;

    display: inline-block;

    margin: 2px;
    padding: 3px;

    color: #055959 !important;
    color: white;
    border: 1px solid #055959;
    -webkit-border-radius: 10px;
       -moz-border-radius: 10px;
            border-radius: 8px;
}

.cut-skill
{
    overflow: hidden;

    max-width: 140px;

    white-space: nowrap;
    text-overflow: ellipsis;
}

.mission-skills-popup
{
    top: 0;
    right: 0;
    bottom: 0;
    left: 0;

    width: 45%;
    max-width: 100% !important;
    max-height: 40% !important;
    margin: auto;
}
.mission-skills-popup .modal-header
{
    background: #047177;
}
.more-skills-button
{
    position: absolute;

    padding: 5px;
}

.opt-in-modal
{
    width: 65% !important;
    margin-top: 10%;
}

.mm-optin-holder label
{
    font-weight: normal !important;
}

.filter-opp-type-list
{
    margin-bottom: 0;
    padding: 8px !important;
}

.mission-sort-btn
{
    padding-left: 50px;
}

.print-mission-more-holder h5
{
    display: inline-block;

    margin-top: 8px;
}

.mission-title-header
{
    text-decoration: none;

    color: #055959;
}
.mission-title-header:visited
{
    color: #055959;
}

.mission-applicant-badge
{
    font-size: 13px;
    line-height: 1;

    position: absolute;
    top: -8px;
    right: 12px;

    min-width: 10px;
    padding: 4px 7px;

    text-align: center;
    vertical-align: top;

    border: 1px solid #ddd;
    border-radius: 15px;
    background-color: white;
}

.mission-applicant-badge-owner
{
    font-weight: bold !important;

    color: white !important;
    background-color: #d00 !important;
}

.candidate-panel
{
    height: 435px;
    padding: 45px 4px 10px 4px !important;
}

.candidate-holder .candidate-panel
{
    border-bottom: none !important;
}

.candidate-panel .user-avatar
{
    margin-top: -40px;
}

.candidate-panel .user-avatar .elgg-avatar-medium-wet4
{
    display: block !important;

    width: 40% !important;
    margin: 0 auto;
}

.candidate-panel .user-info-content
{
    top: 0;

    min-height: 395px;
}
.candidate-panel .user-button-content
{
    position: absolute;
    bottom: 0;

    width: 97%;
    padding: 3%;
}
.candidate-panel .user-job-title
{
    font-weight: bold;

    display: block;
    overflow-x: hidden;

    max-width: 100%;
    margin-bottom: 1px;

    white-space: nowrap;
    text-overflow: ellipsis;
}

.candidate-panel .user-location
{
    display: block;
    overflow-x: hidden;

    max-width: 100%;
    margin-bottom: 1px;

    white-space: nowrap;
    text-overflow: ellipsis;
}

.candidate-panel .user-found-by
{
    display: block;
    overflow-x: hidden;

    max-width: 100%;

    white-space: nowrap;
    text-overflow: ellipsis;
}
