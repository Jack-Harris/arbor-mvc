<div class="container text-center">
    <div class="row">
        <div class="col m-3">
            <h3>Arbor SMS Analysis</h3>
        </div>
        <hr>
        <br>
    </div>
    <div class="row">
        <div class="col">
            <div class="card border-primary bg-light text-primary text-center p-3">
                <h5 class="card-title fw-semibold">Total Messages Sent</h5>
                <p class="fs-4 fw-bold mb-1"><?php echo number_format($totalSentMessages); ?></p>
                <p class="mb-0">Total messages sent</p>
            </div>
        </div>
        <div class="col">
            <div class="card border-primary bg-light text-primary text-center p-3">
                <h5 class="card-title fw-semibold">Unique Recipients</h5>
                <p class="fs-4 fw-bold mb-1"><?php echo number_format($totalUniqueRecipients); ?></p>
                <p class="mb-0">Unique recipients of messages</p>
            </div>
        </div>
        <div class="col">
            <div class="card border-primary bg-light text-primary text-center p-3">
                <h5 class="card-title fw-semibold">Read Rate</h5>
                <p class="fs-4 fw-bold mb-1"><?php echo number_format($readRate, 2); ?>%</p>
                <p class="mb-0">Ratio of delivered to successful messages</p>
            </div>
        </div>
    </div>
    <br>
    <hr>
    <div class="row">
        <div class="col">
            <canvas
                id="pieMessageSuccess"
                data-status='<?php echo json_encode([
                    'sent'      => $messageStatusBreakdown[MessageStatus::SENT] ?? 0,
                    'delivered' => $messageStatusBreakdown[MessageStatus::DELIVERED] ?? 0,
                    'failed'    => $messageStatusBreakdown[MessageStatus::FAILED] ?? 0,
                    'rejected'  => $messageStatusBreakdown[MessageStatus::REJECTED] ?? 0,
                ]); ?>'
            ></canvas>
        </div>
        <div class="col">
            <canvas
                id="pieProviderBreakdown"
                data-providers='<?php echo json_encode($providerBreakdown); ?>'
            ></canvas>
        </div>
        <div class="col">
            <canvas
                id="pieSchoolBreakdown"
                data-schools='<?php echo json_encode($schoolBreakdown); ?>'
            ></canvas>
        </div>
    </div>
    <br>
    <hr>
    <br>
    <div class="row">
        <div class="col">
            <h4>Messages by Day</h4>
        </div>
    </div>
    <div class="row mb-5">
        <div class="col">
            <canvas
                id="lineMessageTimeline"
                height="50"
                data-message-timeline='<?php echo json_encode($messageTimeline); ?>'
            ></canvas>
        </div>
    </div>
</div>

<script>

    document.addEventListener('DOMContentLoaded', function() {
        // Render message breakdown pie chart.
        const messageSuccessChartElement = document.getElementById('pieMessageSuccess');
        let statusCounts = JSON.parse(messageSuccessChartElement.dataset.status);
        const { sent = 0, delivered = 0, failed = 0, rejected = 0 } = statusCounts; 
        createPieChart('Message Breakdown', 'pieMessageSuccess', ['Sent', 'Delivered', 'Failed', 'Rejected'], [sent, delivered, failed, rejected]);

        // Render provider breakdown chart.
        const providerBreakdownChartElement = document.getElementById('pieProviderBreakdown');
        const providers = JSON.parse(providerBreakdownChartElement.dataset.providers);
        createPieChart('Provider Breakdown', 'pieProviderBreakdown', Object.keys(providers), Object.values(providers))

        // Render school breakdown chart.
        const schoolBreakdownChartElement = document.getElementById('pieSchoolBreakdown');
        const schools = JSON.parse(schoolBreakdownChartElement.dataset.schools);
        createPieChart('School Breakdown', 'pieSchoolBreakdown', Object.keys(schools), Object.values(schools))

        // Render line chart.
        const messageTimelineChartElement = document.getElementById('lineMessageTimeline');
        const messageTimeline = JSON.parse(messageTimelineChartElement.dataset.messageTimeline);
        createLineChart('Message Timeline', 'lineMessageTimeline', Object.keys(messageTimeline), Object.values(messageTimeline))
    });

    function createPieChart(title, elementID, labels, data) {
        new Chart(document.getElementById(elementID), {
            type: 'pie',
            data: {
            labels: labels,
            datasets: [{
                label: title,
                data: data,
                hoverOffset: 30
            }]
            },
            options: {
                responsive: true,
                radius: '70%',
                plugins: {
                    title: {
                        display: true,
                        text: title
                    }
                }
            }
        });
    }

    function createLineChart(title, elementID, labels, data) {
        return new Chart(elementID, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: title,
                    data: data,
                }]
            }
        });
    }

  
</script>