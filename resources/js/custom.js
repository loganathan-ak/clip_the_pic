$(document).ready(function(){
    $('#disable_btn').on('click', function(){
         alert('You cannot create more than 10 posts.');
    });

    $('#brand_search').on('input', function () {
        var values = $(this).val();
    
        if (values.length > 2) {
            $.ajax({
                url: '/search-brand',
                method: 'GET',
                data: {
                    brandname: values,
                },
                dataType: 'json',
                success: function (result) {
                    $('#brands_table_body').empty();
                    $('#filter_reset').show();
                    result.brands.forEach(function (brand) {
                        var row = `
                            <tr class="border-t">
                                <td class="p-3">${brand.brand_date}</td>
                                <td class="p-3 font-semibold">${brand.brand_name}</td>
                                <td class="p-3">${brand.industry ?? brand.other_industry}</td>
                                <td class="p-3">
                                    ${brand.web_address ? `<a href="${brand.web_address}" target="_blank" class="text-blue-600 underline">${brand.web_address}</a>` : ''}
                                </td>
                                <td class="p-3">${brand.brand_audience}</td>
                                <td class="p-3">${brand.brand_description ?? ''}</td>
                                <td class="p-2">
                                    ${brand.logo ? `<img src="/storage/${brand.logo}" alt="Logo" class="w-16 h-16 object-contain rounded border" />` : ''}
                                </td>
                                <td class="p-3 flex gap-3 items-center">
                                    <a href="/view-brand/${brand.id}" class="text-blue-600 underline">View</a>
                                    <a href="/edit-brand/${brand.id}" class="text-blue-600 underline">Edit</a>
                                </td>
                            </tr>
                        `;
                        $('#brands_table_body').append(row);
                    });
                },
                error: function (xhr) {
                    console.error('AJAX error:', xhr.responseText);
                }
            });
        }
    });





    function fetchFilteredOrders() {
        var keyword = $('#job_search').val();
        var status = $('#status_filter').val();
    
        if (keyword.length > 2 || status) {
            $.ajax({
                url: '/search-job',
                method: 'GET',
                data: {
                    jobname: keyword,
                    status: status
                },
                dataType: 'json',
                success: function (result) {
                    $('#orders_table_body').empty();
                    $('#filter_reset').show();
                    if (result.orders.length > 0) {
                        const statusColors = {
                            'Pending': 'bg-yellow-200',
                            'Draft': 'bg-gray-200',
                            'Quoted': 'bg-blue-200',
                            'In Progress': 'bg-indigo-100',
                            'Completed': 'bg-green-200',
                            'Quality Checking': 'bg-purple-200'
                        };
                        
                        const statusTextColors = {
                            'Pending': 'text-yellow-800',
                            'Draft': 'text-gray-700',
                            'Quoted': 'text-blue-800',
                            'In Progress': 'text-indigo-800',
                            'Completed': 'text-green-800',
                            'Quality Checking': 'text-purple-800'
                        };
                        
                        // Assuming `credits` is available as a JavaScript array
                        result.orders.forEach(function (order) {
                            console.log(order);
                            const status = order.status || 'Pending';
                            const rowClass = statusColors[status] || 'bg-white';
                            const badgeClass = statusTextColors[status] || 'text-gray-800';
                            const displayStatus = status.toLowerCase() === 'pending' ? 'New' : status;
                        
                            // Get credits_used value
                            const matchedCredit = result.credits?.find(c => c.order_id === order.id);
                            const creditsUsed = matchedCredit?.credits_used ?? 'N/A';
                        
                            const row = `
                                <tr class="${rowClass} border-t">
                                    <td class="px-4 py-3"><a href="/view-order/${order.id}" class="hover:underline">${order.order_id}</a></td>
                                    <td class="px-4 py-2">${order.project_title}</td>
                                    <td class="px-4 py-2">${order.request_type}</td>
                                    <td class="px-4 py-2">${order.size ?? '-'}</td>
                                    <td class="px-4 py-2">${order.duration ?? 'N/A'}hrs</td>
                                    <td class="px-4 py-2">${creditsUsed}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 rounded-full text-sm font-medium capitalize ${badgeClass} bg-white border">
                                            ${displayStatus}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">
                                        <a href="/view-order/${order.id}" class="text-indigo-600 hover:underline">View</a>
                                    </td>
                                </tr>
                            `;
                            $('#orders_table_body').append(row);
                        });
                        
                    } else {
                        $('#orders_table_body').html('<tr><td colspan="9" class="text-center py-4 text-gray-500">No orders found.</td></tr>');
                    }
                },
                error: function (xhr) {
                    console.error('AJAX error:', xhr.responseText);
                }
            });
        }
    }
    
    // Trigger on search input
    $('#job_search').on('input', function () {
        fetchFilteredOrders();
    });
    
    // Trigger on status dropdown change
    $('#status_filter').on('change', function () {
        fetchFilteredOrders();
    });
    


    $('#searchEnquiry').on('input', function () {
        let query = $(this).val();
       
        if(query.length > 2){
            $.ajax({
                url: '/search-enquiry',
                type: 'GET',
                data: { query: query },
                success: function (data) {
                    console.log(data.enquiries);
                    let enquiries = data.enquiries;
                    $("#enquiry_body").empty();
                    $("#filter_reset").show();
                    if (enquiries.length > 0) {
                        enquiries.forEach(function(enquirie) {
                            let row = `
                                <tr> 
                                    <td class="px-4 py-2">${enquirie.name}</td>
                                    <td class="px-4 py-2">${enquirie.email}</td>
                                    <td class="px-4 py-2">${enquirie.phone}</td>
                                    <td class="px-4 py-2">${enquirie.subject}</td>
                                    <td class="px-4 py-2 max-w-xs overflow-hidden truncate" title="${enquirie.message}">
                                        ${enquirie.message.length > 50 ? enquirie.message.substring(0, 50) + '...' : enquirie.message}
                                    </td>
                                    <td class="px-4 py-2">
                                        ${enquirie.file ? `<a href="/storage/${enquirie.file}" target="_blank" class="text-blue-600 underline">Download</a>` : `<span class="text-gray-400">No File</span>`}
                                    </td>
                                    <td class="px-4 py-2">${enquirie.created_at}</td>
                                </tr>
                            `;
                            $("#enquiry_body").append(row);
                        });
                    } else {
                        $("#enquiry_body").append(`
                            <tr>
                                <td colspan="7" class="px-4 py-4 text-center text-gray-500">No enquiries found.</td>
                            </tr>
                        `);
                    }

                }
            });
        }
        
    });







    function designerFilteredOrders() {
        var keyword = $('#designer-search').val();
        if (keyword.length > 2) {
            $.ajax({
                url: '/designer-job-search',
                method: 'GET',
                data: {
                    jobname: keyword,
                },
                dataType: 'json',
                success: function (result) {
                    $('#orders_table_body').empty();
                    $('#filter_reset').show();
    
                    // ✅ Correct check for orders
                    if (result.orders && result.orders.length > 0) {
    
                        const statusColors = {
                            'Pending': 'bg-yellow-200',
                            'Draft': 'bg-gray-200',
                            'Quoted': 'bg-blue-200',
                            'In Progress': 'bg-indigo-100',
                            'Completed': 'bg-green-200',
                            'Quality Checking': 'bg-purple-200'
                        };
    
                        const statusTextColors = {
                            'Pending': 'text-yellow-800',
                            'Draft': 'text-gray-700',
                            'Quoted': 'text-blue-800',
                            'In Progress': 'text-indigo-800',
                            'Completed': 'text-green-800',
                            'Quality Checking': 'text-purple-800'
                        };
    
                        result.orders.forEach(function (order) {
                            const status = order.status || 'Pending';
                            const rowClass = statusColors[status] || 'bg-white';
                            const badgeClass = statusTextColors[status] || 'text-gray-800';
                            const displayStatus = status.toLowerCase() === 'pending' ? 'New' : status;
    
                            // Assigned user name
                            const assignedUser = result.users.find(u => u.id === order.assigned_to);
                            const assignedName = assignedUser?.name ?? '-';
    
                            // Reference file count
                            let referenceCount = 0;
                            try {
                                const files = JSON.parse(order.reference_files);
                                referenceCount = Array.isArray(files) ? files.length : 0;
                            } catch (e) {
                                referenceCount = 0;
                            }
    
                            const row = `
                                <tr class="${rowClass} border-t">
                                    <td class="px-4 py-2"><a href="/admin-vieworders/${order.id}" class="hover:underline">${order.job_id ?? '-'}</a></td>
                                    <td class="px-4 py-2">${order.project_title ?? '-'}</td>
                                    <td class="px-4 py-2">${order.request_type ?? '-'}</td>
                                    <td class="px-4 py-2">${order.sub_services ?? '-'}</td>
                                    <td class="px-4 py-2">${assignedName}</td>
                                    <td class="px-4 py-2">${order.duration ?? 'N/A'}hrs</td>
                                    <td class="px-4 py-2">${referenceCount} File${referenceCount !== 1 ? 's' : ''}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 rounded-full text-sm font-medium capitalize ${badgeClass} bg-white border">
                                            ${displayStatus}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 flex gap-3">
                                        <a href="/admin-vieworders/${order.id}" class="text-indigo-600 hover:underline">View</a>
                                        <a href="/admin-editorders/${order.id}" class="text-indigo-600 hover:underline">Edit</a>
                                    </td>
                                </tr>
                            `;
    
                            $('#orders_table_body').append(row);
                        });
                    } else {
                        $('#orders_table_body').html('<tr><td colspan="9" class="text-center py-4 text-gray-500">No orders found.</td></tr>');
                    }
                },
                error: function (xhr) {
                    console.error('AJAX error:', xhr.responseText);
                }
            });
        }
    }
    

$("#designer-search").on('input', function(){
    designerFilteredOrders();
});





function superadminFilteredOrders() {
    var keyword = $('#job_search_superadmin').val();
    var status = $('#status_filter_superadmin').val();

    if (keyword.length > 2 || status) {
        $.ajax({
            url: '/superadmin-search-job',
            method: 'GET',
            data: {
                jobname: keyword,
                status: status
            },
            dataType: 'json',
            success: function (result) {
                $('#orders_table_head').empty();
                $('#orders_table_body').empty();
                $('#filter_reset').show();
                if (result.orders.length > 0) {
                    var heading = `
                    <tr>
                        <th class="px-4 py-3 text-left">Job id</th>
                        <th class="px-4 py-3 text-left">Project Title</th>
                        <th class="px-4 py-3 text-left">Service</th>
                        <th class="px-4 py-3 text-left">Sub-Service</th>
                        <th class="px-4 py-3 text-left">Duration</th>
                        <th class="px-4 py-3 text-left">Credits</th>
                        <th class="px-4 py-3 text-left">No.of files</th>
                        <th class="px-4 py-3 text-left">Status</th>
                        <th class="px-4 py-3 text-left">Actions</th>
                    </tr>`;
                    $('#orders_table_head').append(heading);

                    result.orders.forEach(function (order) {
                        const statusColors = {
                            'Pending': 'bg-yellow-200',
                            'Draft': 'bg-gray-200',
                            'Quoted': 'bg-blue-200',
                            'In Progress': 'bg-indigo-100',
                            'Completed': 'bg-green-200',
                            'Quality Checking': 'bg-purple-200'
                        };
                    
                        const textColors = {
                            'Pending': 'text-yellow-800',
                            'Draft': 'text-gray-700',
                            'Quoted': 'text-blue-800',
                            'In Progress': 'text-indigo-800',
                            'Completed': 'text-green-800',
                            'Quality Checking': 'text-purple-800'
                        };
                    
                        const status = order.status ? order.status.charAt(0).toUpperCase() + order.status.slice(1) : 'Pending';
                        const rowClass = statusColors[status] || 'bg-white';
                        const badgeClass = textColors[status] || 'text-gray-800';
                        const displayStatus = status.toLowerCase() === 'pending' ? 'New' : status;
                    
                        // Format reference files (optional preview or file count)
                        let referenceCount = 0;
                        try {
                            referenceCount = JSON.parse(order.reference_files)?.length || 0;
                        } catch (e) {
                            referenceCount = 0;
                        }
                    
                        const row = `
                            <tr class="${rowClass} border-t">
                                <td class="px-4 py-2"><a href="/view-order/${order.id}" class="hover:underline">${order.order_id || '-'}</a></td>
                                <td class="px-4 py-2">${order.project_title || '-'}</td>
                                <td class="px-4 py-2">${order.request_type || '-'}</td>
                                <td class="px-4 py-2">${order.sub_services || '-'}</td>
                                <td class="px-4 py-2">${order.duration ? order.duration + ' Hrs' : '-'}</td>
                                <td class="px-4 py-2">${order.credits || '-'}</td> <!-- ✅ SHOW CREDITS -->
                                <td class="px-4 py-3">${referenceCount} Files</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 py-1 rounded-full text-sm font-medium capitalize ${badgeClass} bg-white border">
                                        ${displayStatus}
                                    </span>
                                </td>
                                <td class="px-4 py-2 flex gap-4">
                                    <a href="/view-order/${order.id}" class="text-indigo-600 hover:underline">View</a>
                                    <a href="/edit-order/${order.id}" class="text-indigo-600 hover:underline">Edit</a>
                                </td>
                            </tr>
                        `;
                    
                        $('#orders_table_body').append(row);
                    });
                    
                    
                } else {
                    $('#orders_table_body').html('<tr><td colspan="9" class="text-center py-4 text-gray-500">No orders found.</td></tr>');
                }
            },
            error: function (xhr) {
                console.error('AJAX error:', xhr.responseText);
            }
        });
    }
}


    // Trigger on search input
    $('#job_search_superadmin').on('input', function () {
        superadminFilteredOrders();
    });
    
    // Trigger on status dropdown change
    $('#status_filter_superadmin').on('change', function () {
        superadminFilteredOrders();
    });


    function superadminFilteredsubOrders() {
        var keyword = $('#subjob_search_superadmin').val();
        var status = $('#substatus_filter_superadmin').val();
    
        if (keyword.length > 2 || status) {
            $.ajax({
                url: '/superadmin-search-subjob',
                method: 'GET',
                data: {
                    jobname: keyword,
                    status: status
                },
                dataType: 'json',
                success: function (result) {
                    $('#orders_table_head').empty();
                    $('#orders_table_body').empty();
                    $('#filter_reset').show();
                    if (result.orders.length > 0) {
                        var heading = `
                        <tr>
                            <th class="px-4 py-3 text-left">Job id</th>
                            <th class="px-4 py-3 text-left">Project Title</th>
                            <th class="px-4 py-3 text-left">Service</th>
                            <th class="px-4 py-3 text-left">Sub-Service</th>
                            <th class="px-4 py-3 text-left">Duration</th>
                            <th class="px-4 py-3 text-left">No.of Files</th>
                            <th class="px-4 py-3 text-left">Assigned to</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>`;
                        $('#orders_table_head').append(heading);

                        console.log(result);
    
                        result.orders.forEach(function (order) {

                           const statusColors = {
                            'Pending': 'bg-yellow-200',
                            'Draft': 'bg-gray-200',
                            'Quoted': 'bg-blue-200',
                            'In Progress': 'bg-indigo-100',
                            'Completed': 'bg-green-200',
                            'Quality Checking': 'bg-purple-200'
                        };
                    
                        const textColors = {
                            'Pending': 'text-yellow-800',
                            'Draft': 'text-gray-700',
                            'Quoted': 'text-blue-800',
                            'In Progress': 'text-indigo-800',
                            'Completed': 'text-green-800',
                            'Quality Checking': 'text-purple-800'
                        };
                    
                        const statusRaw = order.status || 'Pending';
                        const status = statusRaw.charAt(0).toUpperCase() + statusRaw.slice(1);
                        const rowClass = statusColors[status] || 'bg-white';
                        const badgeClass = textColors[status] || 'text-gray-800';
                        const displayStatus = status.toLowerCase() === 'pending' ? 'New' : status;
                    
                        // Decode reference files count
                        let referenceCount = 0;
                        try {
                            const files = JSON.parse(order.reference_files || '[]');
                            referenceCount = Array.isArray(files) ? files.length : 0;
                        } catch (e) {
                            referenceCount = 0;
                        }
                    
                        // Assigned user name (if you're passing user list via JS, otherwise use `order.assigned_user_name`)
                        const assignedTo = order.assigned_to_name ?? '-'; // Replace with actual name if included in your API
                    

                        const row = `
                                    <tr class="${rowClass} border-t">
                                        <td class="px-4 py-2"><a href="/view-sub-orders/${order.id}" class="hover:underline">${order.job_id || '-'}</a></td>
                                        <td class="px-4 py-2">${order.project_title || '-'}</td>
                                        <td class="px-4 py-2">${order.request_type || '-'}</td>
                                        <td class="px-4 py-2">${order.sub_services || '-'}</td>
                                        <td class="px-4 py-2">${order.duration ? order.duration + ' Hrs' : '-'}</td>
                                        <td class="px-4 py-3">${referenceCount} File${referenceCount !== 1 ? 's' : ''}</td>
                                        <td class="px-4 py-2">${assignedTo}</td>
                                        <td class="px-4 py-2">
                                            <span class="px-2 py-1 rounded-full text-sm font-medium capitalize ${badgeClass} bg-white border">
                                                ${displayStatus}
                                            </span>
                                        </td>
                                        <td class="px-4 py-2">
                                            <a href="/view-sub-orders/${order.id}" class="text-indigo-600 hover:underline">View</a>
                                        </td>
                                    </tr>
                                `;
                            $('#orders_table_body').append(row);
                        });
                    } else {
                        $('#orders_table_body').html('<tr><td colspan="9" class="text-center py-4 text-gray-500">No orders found.</td></tr>');
                    }
                },
                error: function (xhr) {
                    console.error('AJAX error:', xhr.responseText);
                }
            });
        }
    }


        // Trigger on search input
        $('#subjob_search_superadmin').on('input', function () {
            superadminFilteredsubOrders();
        });
        
        // Trigger on status dropdown change
        $('#substatus_filter_superadmin').on('change', function () {
            superadminFilteredsubOrders();
        });







        function qcListSearch() {
            var keyword = $('#qc_list_search').val();
        
            if (keyword.length > 2) {
                $.ajax({
                    url: '/search_qc_list', // Ensure this route returns JSON
                    method: 'GET',
                    data: {
                        jobname: keyword,
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#orders_table_head').empty();
                        $('#orders_table_body').empty();
                        $('#filter_reset').show();
        
                        if (result.orders.length > 0) {
                            // Table headers
                            let heading = `
                                <tr>
                                    <th class="px-4 py-3 text-left">Job Id</th>
                                    <th class="px-4 py-3 text-left">Project Title</th>
                                    <th class="px-4 py-3 text-left">Request Type</th>
                                    <th class="px-4 py-3 text-left">Assigned To</th>
                                    <th class="px-4 py-3 text-left">Status</th>
                                    <th class="px-4 py-3 text-left">Actions</th>
                                </tr>`;
                            $('#orders_table_head').append(heading);
        
                            // Rows
                            result.orders.forEach(function (order) {
                                let row = `
                                    <tr>
                                        <td class="px-4 py-2"><a href="/qc-view-order/${order.id}" class="hover:underline">${order.job_id}</a></td>
                                        <td class="px-4 py-2">${order.project_title}</td>
                                        <td class="px-4 py-2">${order.request_type}</td>
                                        <td class="px-4 py-2">${order.assigned_to_name ?? 'N/A'}</td>
                                        <td class="px-4 py-2"><span class="text-blue-600 capitalize">${order.status ?? 'pending'}</span></td>
                                        <td class="px-4 py-2 flex gap-3">
                                            <a href="/qc-view-order/${order.id}" class="text-indigo-600 hover:underline">View</a>
                                            <a href="/qc-order/edit/${order.id}" class="text-indigo-600 hover:underline">Edit</a>
                                        </td>
                                    </tr>
                                `;
                                $('#orders_table_body').append(row);
                            });
                        } else {
                            $('#orders_table_body').html('<tr><td colspan="6" class="text-center py-4 text-gray-500">No orders found.</td></tr>');
                        }
                    },
                    error: function (xhr) {
                        console.error('AJAX error:', xhr.responseText);
                    }
                });
            }
        }
        
    
    
        // Trigger on search input
        $('#qc_list_search').on('input', function () {
            qcListSearch();
        });


        function qcMainSearch() {
            var keyword = $('#qc_mainjob_search').val();
            var status = $('#qc_mainstatus_filter').val();
        
            if (keyword.length > 2 || status) {
                $.ajax({
                    url: '/search_qc_mainjob', // Ensure this route returns JSON
                    method: 'GET',
                    data: {
                        jobname: keyword,
                        status: status
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#orders_table_head').empty();
                        $('#orders_table_body').empty();
                        $('#filter_reset').show();
        
                        if (result.orders.length > 0) {
                            // Table headers
                            var heading = `
                            <tr>
                                <th class="px-4 py-3 text-left">Job id</th>
                                <th class="px-4 py-3 text-left">Project Title</th>
                                <th class="px-4 py-3 text-left">Service</th>
                                <th class="px-4 py-3 text-left">Sub-Service</th>
                                <th class="px-4 py-3 text-left">Duration</th>
                                <th class="px-4 py-3 text-left">Credits</th>
                                <th class="px-4 py-3 text-left">No.of Files</th>
                                <th class="px-4 py-3 text-left">Assigned to</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Actions</th>
                            </tr>`;
                        $('#orders_table_head').append(heading);
        
                        result.orders.forEach(function (order) {

                            const statusColors = {
                             'Pending': 'bg-yellow-200',
                             'Draft': 'bg-gray-200',
                             'Quoted': 'bg-blue-200',
                             'In Progress': 'bg-indigo-100',
                             'Completed': 'bg-green-200',
                             'Quality Checking': 'bg-purple-200'
                         };
                     
                         const textColors = {
                             'Pending': 'text-yellow-800',
                             'Draft': 'text-gray-700',
                             'Quoted': 'text-blue-800',
                             'In Progress': 'text-indigo-800',
                             'Completed': 'text-green-800',
                             'Quality Checking': 'text-purple-800'
                         };
                     
                         const statusRaw = order.status || 'Pending';
                         const status = statusRaw.charAt(0).toUpperCase() + statusRaw.slice(1);
                         const rowClass = statusColors[status] || 'bg-white';
                         const badgeClass = textColors[status] || 'text-gray-800';
                         const displayStatus = status.toLowerCase() === 'pending' ? 'New' : status;
                     
                         // Decode reference files count
                         let referenceCount = 0;
                         try {
                             const files = JSON.parse(order.reference_files || '[]');
                             referenceCount = Array.isArray(files) ? files.length : 0;
                         } catch (e) {
                             referenceCount = 0;
                         }
                     
                         // Assigned user name (if you're passing user list via JS, otherwise use `order.assigned_user_name`)
                         const assignedTo = order.assigned_to_name ?? '-'; // Replace with actual name if included in your API
                     
 
                         const row = `
                                     <tr class="${rowClass} border-t">
                                         <td class="px-4 py-2">
                                         <a href="/view-sub-orders/${order.id}" class="text-indigo-600 hover:underline">
                                         ${order.order_id || '-'}
                                         </a></td>
                                         <td class="px-4 py-2">${order.project_title || '-'}</td>
                                         <td class="px-4 py-2">${order.request_type || '-'}</td>
                                         <td class="px-4 py-2">${order.sub_services || '-'}</td>
                                         <td class="px-4 py-2">${order.duration ? order.duration + ' Hrs' : '-'}</td>
                                         <td class="px-4 py-2">${order.credits || '-'}</td>
                                         <td class="px-4 py-3">${referenceCount} File${referenceCount !== 1 ? 's' : ''}</td>
                                         <td class="px-4 py-2">${assignedTo}</td>
                                         <td class="px-4 py-2">
                                             <span class="px-2 py-1 rounded-full text-sm font-medium capitalize ${badgeClass} bg-white border">
                                                 ${displayStatus}
                                             </span>
                                         </td>
                                         <td class="px-4 py-2 flex gap-x-4">
                                             <a href="/view-sub-orders/${order.id}" class="text-indigo-600 hover:underline">View</a>
                                             <a href="/qc_edit_main_job/${order.id}" class="text-indigo-600 hover:underline">Edit</a>
                                         </td>
                                     </tr>
                                 `;
                             $('#orders_table_body').append(row);
                         });
                        } else {
                            $('#orders_table_body').html('<tr><td colspan="6" class="text-center py-4 text-gray-500">No orders found.</td></tr>');
                        }
                    },
                    error: function (xhr) {
                        console.error('AJAX error:', xhr.responseText);
                    }
                });
            }
        }
        

                // Trigger on search input
                $('#qc_mainjob_search').on('input', function () {
                    qcMainSearch();
                });
                
                // Trigger on status dropdown change
                $('#qc_mainstatus_filter').on('change', function () {
                    qcMainSearch();
                });



        
                function qcJobSearch() {
                    var keyword = $('#qc_job_search').val();
                    var status = $('#qc_jobstatus_filter').val();
                
                    if (keyword.length > 2 || status) {
                        $.ajax({
                            url: '/search_qc_job', // Ensure this route returns JSON
                            method: 'GET',
                            data: {
                                jobname: keyword,
                                status: status
                            },
                            dataType: 'json',
                            success: function (result) {
                                
                                $('#orders_table_body').empty();
                                $('#filter_reset').show();
                
                                // ✅ Correct check for orders
                    if (result.orders && result.orders.length > 0) {
    
                        const statusColors = {
                            'Pending': 'bg-yellow-200',
                            'Draft': 'bg-gray-200',
                            'Quoted': 'bg-blue-200',
                            'In Progress': 'bg-indigo-100',
                            'Completed': 'bg-green-200',
                            'Quality Checking': 'bg-purple-200'
                        };
    
                        const statusTextColors = {
                            'Pending': 'text-yellow-800',
                            'Draft': 'text-gray-700',
                            'Quoted': 'text-blue-800',
                            'In Progress': 'text-indigo-800',
                            'Completed': 'text-green-800',
                            'Quality Checking': 'text-purple-800'
                        };
    
                        result.orders.forEach(function (order) {
                            const status = order.status || 'Pending';
                            const rowClass = statusColors[status] || 'bg-white';
                            const badgeClass = statusTextColors[status] || 'text-gray-800';
                            const displayStatus = status.toLowerCase() === 'pending' ? 'New' : status;
    
                            // Assigned user name
                            const assignedUser = result.users.find(u => u.id === order.assigned_to);
                            const assignedName = assignedUser?.name ?? '-';
    
                            // Reference file count
                            let referenceCount = 0;
                            try {
                                const files = JSON.parse(order.reference_files);
                                referenceCount = Array.isArray(files) ? files.length : 0;
                            } catch (e) {
                                referenceCount = 0;
                            }
    
                            const row = `
                                <tr class="${rowClass} border-t">
                                    <td class="px-4 py-2"><a href="/admin-vieworders/${order.id}" class="hover:underline">${order.job_id ?? '-'}</a></td>
                                    <td class="px-4 py-2">${order.project_title ?? '-'}</td>
                                    <td class="px-4 py-2">${order.request_type ?? '-'}</td>
                                    <td class="px-4 py-2">${order.sub_services ?? '-'}</td>
                                    <td class="px-4 py-2">${assignedName}</td>
                                    <td class="px-4 py-2">${order.duration ?? 'N/A'}hrs</td>
                                    <td class="px-4 py-2">${referenceCount} File${referenceCount !== 1 ? 's' : ''}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 rounded-full text-sm font-medium capitalize ${badgeClass} bg-white border">
                                            ${displayStatus}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2 flex gap-3">
                                        <a href="/admin-vieworders/${order.id}" class="text-indigo-600 hover:underline">View</a>
                                        <a href="/admin-editorders/${order.id}" class="text-indigo-600 hover:underline">Edit</a>
                                    </td>
                                </tr>
                            `;
    
                            $('#orders_table_body').append(row);
                        });
                    } else {
                                    $('#orders_table_body').html('<tr><td colspan="6" class="text-center py-4 text-gray-500">No orders found.</td></tr>');
                                }
                            },
                            error: function (xhr) {
                                console.error('AJAX error:', xhr.responseText);
                            }
                        });
                    }
                }
                
        
                        // Trigger on search input
                        $('#qc_job_search').on('input', function () {
                            qcJobSearch();
                        });
                        
                        // Trigger on status dropdown change
                        $('#qc_jobstatus_filter').on('change', function () {
                            qcJobSearch();
                        });
                
        
            
    
});