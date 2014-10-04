
<script id="template-table-inline-actions" type="text/html">
    <% _.each(actions, function(action) { %>

    <a  href="<%= action.href %>" data-id="<%= action.id %>"
        class="action-<%= action.name %>"
        data-container="body" 
        data-toggle="tooltip" 
        data-placement="top" 
        title="<%= action.displayName %>">    
        <span class="fa <%= action.icon %>"></span>
    </a>

    <% }); %>
</script>