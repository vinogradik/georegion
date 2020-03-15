function addDownloadBtn() {
  var imgHandler = $("div#map_handler");

  var map = $("img.map");
  var mapSrc = map.attr("src");

  var tagParagraph = "<p>";
  var tagLabel = "<label>";

  var tagLink = "<a>";
  var elLink = $(tagLink)
    .attr("href", mapSrc)
    .attr("download", "")
    .attr("id", "map_download_link");

  var tagButton = "<button>";
  var elButton = $(tagButton)
    .attr("type", 'button');

  if (lang == "english") {
    elButton.html("Save");
  }
  else {
    elButton.html("Сохранить");
  }

  elLink.append(elButton);

  elLinkParagraph = $(tagParagraph).append(elLink);

  var tagInput = "<input>";
  var elInput = $(tagInput)
    .attr("type", "text")
    .attr("id", "local_map_name")
    .attr("placeholder", "output.gif");

  var elInputLabel = $(tagLabel)
    .attr("for", "local_map_name")
    .attr("id", "local_map_name");

  if (lang == "english") {
    elInputLabel.text(" map name");
  }
  else {
    elInputLabel.html(" имя карты");
  }

  elInputParagraph = $(tagParagraph).append(elInput).append(elInputLabel);

  imgHandler.append(elInputParagraph).append(elLinkParagraph);
};
