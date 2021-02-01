<?php
return array(

      'freshdesk:page:title' => 'Help / Contact Us',

      //search knowledge base
      'freshdesk:knowledge:title' => "Help Content",
      'freshdesk:knowledge:search:title' => "How can we help you today?",
      'freshdesk:knowledge:search:info' => 'Need help? Search our help content to find information and tutorials that will guide you!<br><br><b>Note:</b> The help content is hosted on Freshdesk, a third-party support tool that allows you to easily search articles, as well as submit and track help desk tickets. As you navigate through the help content below, you may be redirected to the Freshdesk website. ',

      'freshdesk:knowledge:explore:title' => 'Explore our help content',

      'freshdesk:knowledge:explore:return' => 'Back to knowledge base categories',

      //submit ticket form
      'freshdesk:ticket:title' => "Submit a ticket",
      'freshdesk:ticket:email' => "Email",
      'freshdesk:ticket:subject' => "Subject",
      'freshdesk:ticket:department' => "Department",
      'freshdesk:ticket:type' => "Type",
      'freshdesk:ticket:attachment' => "Attachment",
      'freshdesk:ticket:description' => "Description",
      'freshdesk:ticket:submit:confirmed' => "Your ticket has been submitted.",
      'freshdesk:ticket:submit:denied' => "Something went wrong, please try again later. Error Code: ",

      'freshdesk:ticket:basic:user_type' => "Occupation",
      'freshdesk:ticket:basic:federal' => 'Organization',
      'freshdesk:ticket:basic:ministry' => 'Ministry',
      'freshdesk:ticket:basic:university' => 'University',
      'freshdesk:ticket:basic:college' => 'College',
      'freshdesk:ticket:basic:highschool' => 'High School',
      'freshdesk:ticket:basic:provincial' => 'Province/Territory',
      'freshdesk:ticket:basic:municipal' => 'Organization',
      'freshdesk:ticket:basic:international' => 'Organization',
      'freshdesk:ticket:basic:ngo' => 'Organization',
      'freshdesk:ticket:basic:community' => 'Organization',
      'freshdesk:ticket:basic:business' => 'Organization',
      'freshdesk:ticket:basic:media' => 'Organization',
      'freshdesk:ticket:basic:retired' => 'Organization',
      'freshdesk:ticket:basic:other' => 'Organization',
      'freshdesk:ticket:basic:institution' => "Institution",

      'freshdesk:ticket:legend:yourinfo' => "Your information",
      'freshdesk:ticket:legend:ticketinfo' => "Ticket information",

      'freshdesk:ticket:types:none' => "...",
      'freshdesk:ticket:types:login' => "Log in credentials",
      'freshdesk:ticket:types:bugs' => "Bugs/Errors",
      'freshdesk:ticket:types:group' => "Group-related",
      'freshdesk:ticket:types:data' => "Data request",
      'freshdesk:ticket:types:training' => "Training",
      'freshdesk:ticket:types:jobs' => "Career Marketplace",
      'freshdesk:ticket:types:enhancement' => "Enhancement",
      'freshdesk:ticket:types:flag' => "Flag content or behaviour",
      'freshdesk:ticket:types:account' => "Account creation",
      'freshdesk:ticket:types:wiki' => "Wiki coding",
      'freshdesk:ticket:types:other' => "Other",

      'freshdesk:knowledge:search:info:embed' => 'Search our knowledge base to find the information you are looking for. For more information vist our <a href="https://gcpedia.gctools-outilsgc.ca/en/support/home">Support Home</a>.',

      //elgg js doens't work the way it should in this version so loopholing through this thing
      'freshdesk:knowledge:search:results:en' => 'Showing %s results.',
      'freshdesk:knowledge:search:results:fr' => 'Indication du %s des résultats.',

      'freshdesk:ticket:matching:en' => '%s matching articles',
      'freshdesk:ticket:matching:fr' => '%s des articles correspondants',

      //additional info
      'freshdesk:additionalinfo' => 'Additional Information',

      'freshdesk:valid' => 'This field is required.',
      'freshdesk:valid:filetypes' => "Invalid file format. Allowed file extensions: txt, gif, jpg, jpeg and png.",

      'freshdesk:warning:header' => 'Configure knowledge Base',
      'freshdesk:warning:body' => 'Knowledge base needs to be synced.',

      'freshdesk:ticket:information' => "Before submitting a ticket, search the help content for information on the most common questions. Can't find an answer? Submit a ticket using the form below. Please be clear when describing your issue and provide a screenshot, if possible. A help desk agent will get back to you within 2 business days.",
      'freshdesk:ticket:information:note' => "<b>Note:</b> We are now using Freshdesk as a third-party tool to manage help desk activities. After submitting a ticket, you should receive a confirmation email with a link to your ticket.",
    
      'freshdesk:paths:reason:label' => "What is your primary reason for submitting a ticket?",
      'freshdesk:paths:reason:select' => "Please select a reason",
      'freshdesk:paths:reason:account' => "I need assistance with my account / login",
      'freshdesk:paths:reason:gcconnex:issue' => "I am experiencing an issue on GCconnex",
      'freshdesk:paths:reason:gcpedia:issue' => "I am experiencing an issue on GCpedia",
      'freshdesk:paths:reason:gcconnex:assist' => "I need assistance using GCconnex",
      'freshdesk:paths:reason:gcpedia:assist' => "I need assistance using GCpedia",
      'freshdesk:paths:reason:stats' => "I would like to request statistics on my page",
      'freshdesk:paths:reason:other' => "Other (please specify)",

      'freshdesk:paths:account:label' => "What is your account issue?",
      'freshdesk:paths:account:new' => "I need help setting up a new account",
      'freshdesk:paths:account:email' => "I need to update the email on my account",
      'freshdesk:paths:account:password' => "I need to reset my password",
    
      'freshdesk:paths:assistance:label' => "Which section do you need assistance with?",
      'freshdesk:paths:assistance:groups' => "Groups",
      'freshdesk:paths:assistance:career' => "Career Marketplace",
      'freshdesk:paths:assistance:files' => "Files",
      'freshdesk:paths:assistance:profile' => "Profile",
      
      'freshdesk:paths:pageurl:label' => "Page URL",
      
      'freshdesk:paths:previousemail:label' => "Previous email",
      
      'freshdesk:paths:pwdreset:label' => "I have tried the <a href='https://gcconnex.gc.ca/forgotpassword' target='_blank'>reset password</a> function",
      'freshdesk:paths:pwdreset:label:wiki' => "I have tried the <a href='https://www.gcpedia.gc.ca/gcwiki/index.php?title=Special:UserLogin&returnto=Main+Page#byEmail' target='_blank'>reset password</a> function",
      'freshdesk:paths:opted:label' => "I have <a href='https://gcconnex.gc.ca/missions/main#optinPopup' target='_blank'>opted in</a> to the Career marketplace. Opting in will allow you to search, post and apply to opportunities on the Career Marketplace.",
      
      'freshdesk:paths:data_ongoing:label' => "Make request ongoing",
      'freshdesk:paths:data_date_to:label' => "End date",
      'freshdesk:paths:data_date_from:label' => "Start date",
      'freshdesk:paths:data_date_format:label' => "Format: yyyy-mm-dd",
      'freshdesk:paths:data_report_to:label' => "Email report to",

      'freshdesk:paths:other:alert' => "If you are experiencing an error, please include a screenshot or an error code.",
      'freshdesk:paths:gcpedia:alert' => "If you are contacting help desk about coding assistance with your page, please refer to the <a href='https://www.gcpedia.gc.ca/wiki/Help:Coding_Resources'>coding resources documentation</a>.",
    );
