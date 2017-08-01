<?php ?>

<style>

#results-en {
  padding:5px;
  overflow:auto;
}

#searchResults .article-panel {
  display:none;
}

.results-list li {
  display:none;
}


.expand-header:hover {
  cursor: pointer;
}

.article-feedback {
  width:100%;
  border-top: 1px solid #ddd;
  padding-top: 15px;
}

.article-cat {
  background-color: #fff;
  border-radius: 2px;
  list-style: none;
  box-shadow: 0 0 0 1px rgba(0,0,0,.1), 0 2px 3px rgba(0,0,0,.2);
  margin:5px;
  min-height:250px;
  padding: 5px 10px;
}

.article-cat .heading {
  padding:10px;
  background:white;
}

.article-cat h3 {
  margin:5px 0;
}

.folders {
  list-style: none;
}

.folders li {
  margin-bottom:5px;
}

#results-en {
  padding:5px;
  overflow:auto;
  min-height: 545px;
}

.folder-display {
  display: none;
}

.heading-panel {
  margin:5px;
}

.heading-panel a {
  float:left;
  background-color: #fff;
  border-radius: 2px;
  list-style: none;
  box-shadow: 0 0 0 1px rgba(0,0,0,.1), 0 2px 3px rgba(0,0,0,.2);
  margin-right: 7px;
  padding:20px 15px;
  overflow: auto;
  width: 63px;
  height: 63px;
  text-align: center;
  color: #919191;
}

.heading-panel div {
  background-color: #fff;
  border-radius: 2px;
  list-style: none;
  box-shadow: 0 0 0 1px rgba(0,0,0,.1), 0 2px 3px rgba(0,0,0,.2);
  margin:0 0 0 70px;
  padding:20px 15px;
}

.heading-panel h2 {
  margin:0;
  border:none;
}

.collapsed .collapse-plus:before {
  content:"\f196";
}

.article-panel {
  background-color: #fff;
  border-radius: 2px;
  list-style: none;
  box-shadow: 0 0 0 1px rgba(0,0,0,.1), 0 2px 3px rgba(0,0,0,.2);
  margin:5px;
  padding: 15px;
}

.article-panel .article-list {
  list-style: none;
  padding:5px;
}

#results-listing {
  list-style: none;
  padding:5px;
}

.article-listing {
  border-bottom: 1px solid #eee;
}

.article-listing .list-title {
  margin: 15px 2px;
}

.article-listing:last-child {
  border-bottom: none !important;
}

.article-content {
  margin: 0 5px;
  padding: 0 5px 10px;
}

.article-hi {
      margin: 0 0 10px 5px;
      display:none;
      font-style: italic;
}

.collapse-plus {
  padding-right: 10px;
}

#filter-count {
  margin: 5px;
}

.search-info {
  margin: 5px;
  display: block;
}

.relatedArticles {
  display: none;
  padding: 5px 10px;
  border-top: none;
  border-radius: 8px;
  -moz-border-radius: 10px;
  -webkit-border-radius: 10px;
  border-top-left-radius: 0;
  border-top-right-radius: 0;
  color: white;
  margin: 1px;
}

.form-ticket-panel {
  background-color: #fff;
  border-radius: 2px;
  list-style: none;
  box-shadow: 0 0 0 1px rgba(0,0,0,.1), 0 2px 3px rgba(0,0,0,.2);
}

.form-ticket-panel h2 {
  border: none;
}

.form-ticket-panel > .panel-body {
  padding:10px;
}

.additional-info {
  margin: 0 10px;
}

@media (min-width: 540px){
  .category-card {
    float: left;
    width: 50%;
  }
}

@media (min-width: 980px){
  .category-card {
    float: left;
    width: 33.3333333333%;
  }
}
