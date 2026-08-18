<?php
namespace skynettechnologies\craftskynetaccessibilityvideosubtitle;
use Craft;

if (Craft::$app->getUser()->getIdentity()) {
      $currentUser = Craft::$app->getUser()->getIdentity();
  
      // User's email
      $id = $currentUser->id;             // User's ID
     $userEmail =  $currentUser->email;
     $username =  $currentUser->username;
    //  echo $userEmail;
    //  echo $username;
    
  }
$resource_path = "@skynettechnologies/craftskynetaccessibilityvideosubtitle/resources/";

 

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
<!-- Font Awesome 6 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>


<div id="app">
        <!-- PAGE HEADER -->
        <div class="page-header">
            <h1><i class="fas fa-closed-captioning me-2" style="color:var(--primary);"></i>SkynetAccessibility Video Subtitle</h1>
            <div class="header-right" id="headerRight">
                <!-- Rendered by JS -->
            </div>
        </div>
        <!-- MAIN CONTENT -->
        <div id="mainContent">
            <!-- ---------- PLAN SELECTION ---------- -->
            <div id="planSelection" style="display:none;">
                <div class="row g-4" id="planCards">
                    <!-- Rendered by JS -->
                </div>
            </div>
            <!-- ---------- ANALYTICS DASHBOARD ---------- -->
            <div id="analyticsDashboard">
                <!-- Filters -->
                <div class="mb-3">
                    <div class="row align-items-center g-2">
                        <div class="col-12 col-md d-flex flex-wrap align-items-center justify-content-md-end gap-2 filters-row">
                            <div class="dropdown d-none" id="dateDropdown">
                                <button class="btn btn-outline-filter dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false" id="dateRangeToggle">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span id="dateRangeLabel">Loading…</span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-custom" id="dateDropdownMenu"></ul>
                            </div>
                            <div class="widget-language-setting">
                                <div class="mb-0 p-0 m-0 form-switch">
                                    <input type="checkbox" id="lang-widget-toggle" class="form-check-input" checked>
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <span>Generate subtitles based on widget language</span>
                                    <!--<span class="widget-language-info"><span class="material-symbols-outlined">info</span></span>-->
                                </div>
                            </div>
                            <select class="filter-select" id="languageFilter">
                                <option value="all">All Languages</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Quota Alert -->
                <div id="quotaAlert" class="row mb-4" style="display:none;">
                    <div class="col-12">
                        <div class="alert alert-danger alert-quota mb-0 d-flex align-items-center gap-3">
                            <i class="fas fa-exclamation-triangle" style="font-size:24px;color:var(--danger);"></i>
                            <div>
                                <div class="fw-bold fs-6 mb-1">Quota Limit Reached</div>
                                <p class="mb-0">You have reached your quota limit. Please upgrade your plan to continue.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Loading / Error -->
                <div id="apiLoading" style="display:none;">
                    <div class="spinner-overlay">
                        <div class="spinner-border text-primary" role="status" style="width:3rem;height:3rem;"></div>
                        <p class="mt-3 text-muted">Loading video data…</p>
                    </div>
                </div>
                <div id="apiError" style="display:none;">
                    <div class="error-banner">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <span id="apiErrorMsg">Failed to load data.</span>
                        <button class="btn btn-sm btn-outline-danger ms-3" id="retryBtn">
                            <i class="fas fa-redo me-1"></i> Retry
                        </button>
                    </div>
                </div>

                <!-- Stat Cards -->
                <div class="row g-3 mb-3" id="statCardsRow">
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card">
                            <div class="card-body d-flex align-items-center gap-3 py-3 px-3 px-xl-4">
                                <div class="icon-box"><i class="fas fa-video"></i></div>
                                <div>
                                    <div class="fw-medium" style="font-size:16px;color:var(--primary);">Videos Remediated</div>
                                    <div class="fw-bold stat-value" style="font-size:30px;" id="statVideos">0</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card">
                            <div class="card-body d-flex align-items-center gap-3 py-3 px-3 px-xl-4">
                                <div class="icon-box"><i class="fas fa-clock"></i></div>
                                <div>
                                    <div class="fw-medium" style="font-size:16px;color:var(--primary);">Total Time Limit</div>
                                    <div class="fw-bold stat-value" style="font-size:30px;" id="statTotalLimit">0 <small style="font-size:14px;font-weight:400;">min</small></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card">
                            <div class="card-body d-flex align-items-center gap-3 py-3 px-3 px-xl-4">
                                <div class="icon-box"><i class="fas fa-hourglass-half"></i></div>
                                <div>
                                    <div class="fw-medium" style="font-size:16px;color:var(--primary);">Spent Duration</div>
                                    <div class="fw-bold stat-value" style="font-size:30px;" id="statSpent">0:00</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="card stat-card">
                            <div class="card-body d-flex align-items-center gap-3 py-3 px-3 px-xl-4">
                                <div class="icon-box"><i class="fas fa-hourglass-start"></i></div>
                                <div>
                                    <div class="fw-medium" style="font-size:16px;color:var(--primary);">Remaining Duration</div>
                                    <div class="fw-bold stat-value" style="font-size:30px;" id="statRemaining">0:00</div>
                                    <div id="lowRemainingBadge" style="display:none;color:var(--danger);font-size:12px;margin-top:2px;">
                                        <i class="fas fa-exclamation-circle" style="font-size:12px;"></i> Low remaining quota
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Charts -->
                <div class="row g-3 mb-4 align-items-stretch">
                    <div class="col-12 col-lg-6">
                        <div class="card stat-card h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                                <div id="circularContainer"></div>
                                <div class="text-center mt-3" style="font-size:14px;" id="usageCaption">Loading…</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-6">
                        <div class="card stat-card h-100">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
                                <div style="width:100%;height:200px;position:relative;">
                                    <canvas id="pieChart"></canvas>
                                </div>
                                <div class="d-flex flex-wrap justify-content-center gap-3 mt-2" id="pieLegend"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Video Library -->
                <div class="video-container">
                    <div class="row mb-3 align-items-center">
                        <div class="col-12 d-flex align-items-center justify-content-between">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fas fa-video icon-md" style="color:var(--primary);"></i>
                                <h5 class="fw-bold mb-0">Video Library</h5>
                            </div>
                            <span class="fw-semibold" style="background:var(--primary-light);color:var(--primary);border-radius:999px;padding:4px 14px;font-size:13px;" id="videoCountBadge">0 Videos</span>
                        </div>
                    </div>
                    <div class="row g-3" id="videoGrid"></div>
                    <div id="emptyState" class="row my-5" style="display:none;">
                        <div class="col-12 text-center">
                            <i class="fas fa-video-slash" style="font-size:48px;color:var(--gray);"></i>
                            <h5 class="mt-3 fw-semibold">No videos found</h5>
                            <p class="text-muted">Try adjusting your filters or upload a video.</p>
                        </div>
                    </div>
                </div>

            </div>
            <!-- /analyticsDashboard -->
        </div>
        <!-- /mainContent -->

        <!-- ============================================================
        VIDEO PREVIEW MODAL
        ============================================================ -->
        <div class="modal fade video-modal" id="videoModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title fw-semibold">Video Preview</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body pt-3 pb-4">
                        <div style="position:relative;padding-top:56.25%;">
                            <iframe id="videoIframe" src="" title="YouTube video player"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen
                            style="position:absolute;top:0;left:0;width:100%;height:100%;border-radius:16px;border:none;">
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============================================================
    UPGRADE MODAL
    ============================================================ -->
    <div class="modal fade upgrade-modal" id="upgradeModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title">Upgrade Plan</h5>
                    <button type="button" class="upgrade-close-btn" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="modal-body pb-4" id="upgradeModalBody">
                    <!-- Rendered by JS -->
                </div>
            </div>
        </div>
    </div>
</div>
