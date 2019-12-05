<% if LinkURL %>
    <a{$IDAttr}{$ClassAttr} href="{$LinkURL}"{$TargetAttr}><% include LinkIcon %><% if $DisplayTitle %>{$Title}<% end_if %></a>
<% end_if %>
