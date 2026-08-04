<!--begin::Scrolltop-->
<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">{!! getIcon('arrow-up', '') !!}</div>
<div id="bellcurveModal" class="bellcurveModal" style="display:none;">
    <button type="button" class="btn btn-outline btn-active-light p-2 bg-light-info" id="">
        <div class="d-flex flex-column ">
            <!-- <div class="symbol symbol-25px mb-2 d-flex justify-content-center">
                <div class="symbol-label fs-2 fw-semibold bg-light-info">
                    <i class="ki-solid ki-star fs-2 text-info"></i>
                </div>
            </div> -->
            <b>Bell curve info.</b>
        </div>
    </button>
</div>
<div id="budgetGModal" class="budgetGModal" style="display:none;">
    <button type="button" class="btn btn-outline btn-active-light p-2 bg-light-warning" id="">
        <div class="d-flex flex-column">
            <!-- <div class="symbol symbol-25px mb-2 d-flex justify-content-center">
                <div class="symbol-label fs-2 fw-semibold bg-light">
                    %
                </div>
            </div> -->
            <b>Budget range G.</b>
        </div>
    </button>
</div>
<div id="approveBudgetModal" class="approveBudgetModal" style="display:none;">
    <button type="button" class="btn btn-outline btn-active-light p-2 bg-light-success" id="">
        <div class="d-flex flex-column">
            <!-- <div class="symbol symbol-25px mb-2 d-flex justify-content-center">
                <div class="symbol-label fs-2 fw-semibold bg-light-success">
                    <i class="ki-solid ki-wallet fs-2 text-success"></i>
                </div>
            </div> -->
            <b>Approve Budget</b>
        </div>
    </button>
</div>
<!--end::Scrolltop-->
<style>
    
    .bellcurveModal {
        position: fixed;
        display: none;
        cursor: pointer;
        z-index: 105;
        justify-content: center;
        align-items: center;
        /* width: 36px; */
        /* height: 36px; */
        bottom: 5px;
        right: 26em;
        /* background-color: var(--bs-scrolltop-bg-color); */
        box-shadow: var(--bs-scrolltop-box-shadow);
        /* opacity: 0; */
        transition: color 0.2s ease;
        border-radius: 0.475rem;
        color: #000000;
        font-size: 12px;
        font-weight: bold;
        /* width: 50px; */
        text-align: center;
        background-color: white;
    }
    .bellcurveModal {
        /* opacity: var(--bs-scrolltop-opacity-on); */
        animation: animation-scrolltop 0.4s ease-out 1;
        display: flex;
    }
    .budgetGModal {
        position: fixed;
        display: none;
        cursor: pointer;
        z-index: 105;
        justify-content: center;
        align-items: center;
        /* width: 36px; */
        /* height: 36px; */
        bottom: 5px;
        right: 15em;
        /* background-color: var(--bs-scrolltop-bg-color); */
        box-shadow: var(--bs-scrolltop-box-shadow);
        /* opacity: 0; */
        transition: color 0.2s ease;
        border-radius: 0.475rem;
        color: #000000;
        font-size: 12px;
        font-weight: bold;
        /* width: 50px; */
        text-align: center;
        background-color: white;
    }
    .budgetGModal {
        /* opacity: var(--bs-scrolltop-opacity-on); */
        animation: animation-scrolltop 0.4s ease-out 1;
        display: flex;
    }
    .approveBudgetModal {
        position: fixed;
        display: none;
        cursor: pointer;
        z-index: 105;
        justify-content: center;
        align-items: center;
        /* width: 36px; */
        /* height: 36px; */
        bottom: 5px;
        right: 4em;
        /* background-color: var(--bs-scrolltop-bg-color); */
        box-shadow: var(--bs-scrolltop-box-shadow);
        /* opacity: 0; */
        transition: color 0.2s ease;
        border-radius: 0.475rem;
        color: #000000;
        font-size: 12px;
        font-weight: bold;
        /* width: 50px; */
        text-align: center;
        background-color: white;
    }
    .approveBudgetModal {
        /* opacity: var(--bs-scrolltop-opacity-on); */
        animation: animation-scrolltop 0.4s ease-out 1;
        display: flex;
    }
</style>