// ============================================================
//  MONIKA Admin Dashboard — Google Apps Script Backend
//  PT Telkom Indonesia · Unit Optima
//  Code.gs — Semua logika backend dan route handler
// ============================================================

// ───────────────────────────────────────────────────────────
//  KONFIGURASI GLOBAL
// ───────────────────────────────────────────────────────────
var SPREADSHEET_ID = '';  // Akan diisi otomatis oleh setupDatabase()
var SCRIPT_PROPS   = PropertiesService.getScriptProperties();

// Cache references to optimize speed (resets per request execution)
var _cachedSpreadsheet = null;
var _cachedSheets      = {};
var _cachedSheetData   = {};

// Performance stats tracker
var _perfStats = {
  sheetReads: 0,
  openByIdCalls: 0,
  getSheetCalls: 0,
  rowsCount: {}
};

// Nama Sheet
var SHEET = {
  DEPLOYMENT : 'Deployment',
  USERS      : 'Users',
  LIVE_LOG   : 'LiveLog',
  SETTINGS   : 'Settings',
  DATELS     : 'MasterDatels',
  STOS       : 'MasterStos',
  MITRAS     : 'MasterMitras',
  EBIS_MANUAL_INPUT : 'EbisManualInput'
};

// ───────────────────────────────────────────────────────────
//  ENTRY POINT — Web App
// ───────────────────────────────────────────────────────────
function doGet(e) {
  var page = (e && e.parameter && e.parameter.page) ? e.parameter.page : 'dashboard';

  // API endpoints
  if (page === 'api') {
    return handleApi(e);
  }

  // Serve HTML shell
  var tmpl = HtmlService.createTemplateFromFile('index');
  tmpl.page = page;
  tmpl.currentUser = getCurrentUser();
  return tmpl.evaluate()
    .setTitle('MONIKA — Admin Dashboard · PT Telkom')
    .addMetaTag('viewport', 'width=device-width, initial-scale=1, viewport-fit=cover')
    .setXFrameOptionsMode(HtmlService.XFrameOptionsMode.ALLOWALL);
}

function doPost(e) {
  return handleApi(e, true);
}

// ───────────────────────────────────────────────────────────
//  API ROUTER
// ───────────────────────────────────────────────────────────
function handleApi(e, isPost) {
  var action = (e && e.parameter && e.parameter.action) ? e.parameter.action : '';
  var result;

  try {
    switch (action) {
      // Dashboard
      case 'getDashboardStats' : result = getDashboardStats();         break;
      case 'getTrendData'      : result = getTrendData(e.parameter);   break;
      case 'getTopMitras'      : result = getTopMitras(e.parameter);   break;
      case 'getWorkloadDay'    : result = getWorkloadDay(e.parameter); break;
      case 'getLiveTracking'   : result = getLiveTracking();           break;

      // Deployment CRUD
      case 'getDeployments'    : result = getDeployments(e.parameter); break;
      case 'addDeployment'     : result = addDeployment(e.parameter);  break;
      case 'updateDeployment'  : result = updateDeployment(e.parameter); break;
      case 'deleteDeployment'  : result = deleteDeployment(e.parameter); break;
      case 'importDeployments' : result = importDeployments(e.parameter); break;

      // Users
      case 'getUsers'          : result = getUsers();                  break;
      case 'approveUser'       : result = approveUser(e.parameter);    break;
      case 'updateUserRole'    : result = updateUserRole(e.parameter); break;
      case 'addUser'           : result = addUser(e.parameter);        break;
      case 'deleteUser'        : result = deleteUser(e.parameter);     break;

      // Settings
      case 'getSettings'       : result = getSettings();               break;
      case 'saveSettings'      : result = saveSettings(e.parameter);   break;

      // Master Data
      case 'getMasterData'     : result = getMasterData();             break;
      case 'addMasterItem'     : result = addMasterItem(e.parameter);  break;
      case 'updateMasterItem'  : result = updateMasterItem(e.parameter); break;
      case 'deleteMasterItem'  : result = deleteMasterItem(e.parameter); break;

      // Filter Options
      case 'getFilterOptions'  : result = getFilterOptions();          break;

      default:
        result = { success: false, message: 'Unknown action: ' + action };
    }
  } catch (err) {
    result = { success: false, message: err.message };
  }

  return ContentService.createTextOutput(JSON.stringify(result))
    .setMimeType(ContentService.MimeType.JSON);
}

// ───────────────────────────────────────────────────────────
//  CLIENT CALL — dipanggil via google.script.run dari HTML
//  Menerima plain object params, bukan GAS event object
// ───────────────────────────────────────────────────────────
function clientCall(params) {
  var startTime = new Date().getTime();
  var action = params.action || '';
  var result;

  try {
    switch (action) {
      // Dashboard
      case 'getDashboardStats'  : result = getDashboardStats();        break;
      case 'getTrendData'       : result = getTrendData(params);       break;
      case 'getTopMitras'       : result = getTopMitras(params);       break;
      case 'getWorkloadDay'     : result = getWorkloadDay(params);     break;
      case 'getLiveTracking'    : result = getLiveTracking();          break;

      // Deployment CRUD
      case 'getDeployments'     : result = getDeployments(params);     break;
      case 'addDeployment'      : result = addDeployment(params);      break;
      case 'updateDeployment'   : result = updateDeployment(params);   break;
      case 'deleteDeployment'   : result = deleteDeployment(params);   break;
      case 'importDeployments'  : result = importDeployments(params);  break;

      // Update Data (progres)
      case 'getUpdateList'      : result = getUpdateList(params);      break;
      case 'updateProgres'      : result = updateProgres(params);      break;

      // Lihat Data
      case 'getLihatData'       : result = getLihatData(params);       break;

      // Progress Overview
      case 'getProgressOverview': result = getProgressOverview(params);      break;

      // Users
      case 'getUsers'           : result = getUsers();                 break;
      case 'approveUser'        : result = approveUser(params);        break;
      case 'addUser'            : result = addUser(params);            break;
      case 'deleteUser'         : result = deleteUser(params);         break;

      // Settings
      case 'getSettings'        : result = getSettings();              break;
      case 'saveSettings'       : result = saveSettings(params);       break;

      // Master Data
      case 'getMasterData'      : result = getMasterData();            break;
      case 'addMasterItem'      : result = addMasterItem(params);      break;
      case 'updateMasterItem'   : result = updateMasterItem(params);   break;
      case 'deleteMasterItem'   : result = deleteMasterItem(params);   break;

      // Filter Options
      case 'getFilterOptions'   : result = getFilterOptions();         break;

      // Utility
      case 'reseedData'         : result = reseedData();               break;

      default:
        result = { success: false, message: 'Unknown action: ' + action };
    }
  } catch (err) {
    result = { success: false, message: err.message };
  }

  if (result && typeof result === 'object') {
    result._debug = {
      executionTimeMs: new Date().getTime() - startTime,
      perf: _perfStats
    };
  }

  return result;
}

// ───────────────────────────────────────────────────────────
//  UPDATE DATA — daftar order OPEN yang belum Rekon
// ───────────────────────────────────────────────────────────
function getUpdateList(params) {
  var rows  = getMergedDeployments();
  var datel = params.datel   || '';
  var sto   = params.sto     || '';
  var search= (params.search || '').toLowerCase();
  var page  = parseInt(params.page  || 1);
  var limit = parseInt(params.limit || 10);

  rows = rows.filter(function(r) {
    return r.StatusOrder === 'OPEN';
  });
  if (datel)  rows = rows.filter(function(r) { return _matchFilter(r.Datel, datel); });
  if (sto)    rows = rows.filter(function(r) { return _matchFilter(r.STO,   sto);   });
  if (search) rows = rows.filter(function(r) {
    return String(r.StarClickID).toLowerCase().includes(search) ||
           String(r.NamaCustomer).toLowerCase().includes(search);
  });

  rows.sort(function(a, b) { return Number(b.ID) - Number(a.ID); });

  var total  = rows.length;
  var sliced = rows.slice((page - 1) * limit, page * limit);
  return { success: true, data: sliced, total: total, page: page, totalPages: Math.ceil(total / limit) };
}

function updateProgres(params) {
  var sh   = getSheet(SHEET.EBIS_MANUAL_INPUT);
  var data = sh.getDataRange().getValues();
  if (data.length < 1) return { success: false, message: 'Sheet kosong' };
  
  var headers = data[0];
  var idxId = headers.indexOf('ID');
  var idxStar = headers.indexOf('StarClickID');
  var idxProg = headers.indexOf('Progres');
  var idxCommit = headers.indexOf('CommitmentDate');
  var idxTglUpdate = headers.indexOf('TanggalUpdateProgres');
  var idxMitra = headers.indexOf('Mitra');
  var idxUser = headers.indexOf('UpdatedBy');
  var idxUpdated = headers.indexOf('UpdatedAt');
  
  var now   = Utilities.formatDate(new Date(), 'Asia/Jakarta', 'yyyy-MM-dd HH:mm:ss');
  var today = Utilities.formatDate(new Date(), 'Asia/Jakarta', 'yyyy-MM-dd');
  var id    = parseInt(params.ID);

  for (var i = 1; i < data.length; i++) {
    if (parseInt(data[i][idxId]) === id) {
      var row = data[i];
      if (params.Progres && idxProg !== -1)        row[idxProg]  = params.Progres;
      if (params.CommitmentDate && idxCommit !== -1) row[idxCommit] = params.CommitmentDate;
      if (idxTglUpdate !== -1)                      row[idxTglUpdate] = today;
      if (params.Mitra && idxMitra !== -1)          row[idxMitra] = params.Mitra;
      if (idxUser !== -1)                           row[idxUser]  = getCurrentUser();
      if (idxUpdated !== -1)                        row[idxUpdated] = now;

      sh.getRange(i + 1, 1, 1, row.length).setValues([row]);
      _appendLog(id, String(row[idxStar || 1]), String(params.Progres || row[idxProg]), String(params.CommitmentDate || row[idxCommit]));
      return { success: true, message: 'Progres berhasil diperbarui' };
    }
  }
  return { success: false, message: 'Data tidak ditemukan' };
}

// ───────────────────────────────────────────────────────────
//  LIHAT DATA — data lengkap dengan banyak filter
// ───────────────────────────────────────────────────────────
function getLihatData(params) {
  var rows  = getMergedDeployments();
  var search  = (params.search   || '').toLowerCase();
  var datel   = params.datel     || '';
  var sto     = params.sto       || '';
  var progres = params.progres   || '';
  var status  = params.status    || '';
  var mitra   = params.mitra     || '';
  var batch   = params.batch     || '';
  var startDate = params.startDate || '';
  var endDate   = params.endDate   || '';
  var page    = parseInt(params.page  || 1);
  var limit   = parseInt(params.limit || 15);

  if (search)  rows = rows.filter(function(r) {
    return String(r.StarClickID).toLowerCase().includes(search) ||
           String(r.NamaCustomer).toLowerCase().includes(search) ||
           String(r.Datel).toLowerCase().includes(search) ||
           String(r.STO).toLowerCase().includes(search);
  });
  if (datel)   rows = rows.filter(function(r) { return _matchFilter(r.Datel, datel); });
  if (sto)     rows = rows.filter(function(r) { return _matchFilter(r.STO, sto); });
  if (progres) rows = rows.filter(function(r) { return _matchFilter(r.Progres, progres); });
  if (status)  rows = rows.filter(function(r) { return _matchFilter(r.StatusOrder, status); });
  if (mitra)   rows = rows.filter(function(r) { return _matchFilter(r.Mitra, mitra); });
  if (batch)   rows = rows.filter(function(r) { return _matchFilter(r.Batch, batch); });

  if (startDate) rows = rows.filter(function(r) {
    return r.CreatedAt && String(r.CreatedAt).slice(0,10) >= startDate;
  });
  if (endDate) rows = rows.filter(function(r) {
    return r.CreatedAt && String(r.CreatedAt).slice(0,10) <= endDate;
  });

  rows.sort(function(a, b) { return Number(b.ID) - Number(a.ID); });

  var total  = rows.length;
  var sliced = rows.slice((page - 1) * limit, page * limit);
  return { success: true, data: sliced, total: total, page: page, totalPages: Math.ceil(total / limit) };
}

// ───────────────────────────────────────────────────────────
//  PROGRESS OVERVIEW
// ───────────────────────────────────────────────────────────
function getProgressOverview(params) {
  var rows = getMergedDeployments();
  
  var unique = function(arr) {
    var seen = {}, out = [];
    arr.forEach(function(v) { if (v && !seen[v]) { seen[v] = true; out.push(v); } });
    return out.sort();
  };
  var stoList   = unique(rows.map(function(r) { return r.STO; }));
  var datelList = unique(rows.map(function(r) { return r.Datel; }));
  var mitraList = unique(rows.map(function(r) { return r.Mitra; }));

  var filteredRows = _filterOverviewRows(rows, params);
  var totalAll = filteredRows.length;

  var stages = [
    'ON DESK', 'SURVEY', 'PERIJINAN', 'DRM', 'APPROVED BY EBIS',
    'MATDEV', 'INSTALASI', 'SELESAI FISIK', 'GOLIVE',
    'PS', 'UJI TERIMA', 'REKON'
  ];

  var datels = unique(filteredRows.map(function(r) { return String(r.Datel || '').trim().toUpperCase(); }));
  var datelLabels = datels.filter(Boolean);

  var stackedData = {};
  stages.forEach(function(stage) {
    stackedData[stage] = [];
    datelLabels.forEach(function(datel) {
      var count = filteredRows.filter(function(r) {
        return String(r.Datel || '').trim().toUpperCase() === datel && String(r.Progres || '').trim().toUpperCase() === stage;
      }).length;
      stackedData[stage].push(count);
    });
  });

  var statusOrders = unique(filteredRows.map(function(r) { return r.StatusOrder; })).filter(Boolean);
  var ihldStatuses = statusOrders;
  var ihldStackedData = {};
  ihldStatuses.forEach(function(status) {
    ihldStackedData[status] = [];
    datelLabels.forEach(function(datel) {
      var count = filteredRows.filter(function(r) {
        return String(r.Datel || '').trim().toUpperCase() === datel && r.StatusOrder === status;
      }).length;
      ihldStackedData[status].push(count);
    });
  });

  var now = new Date();
  var todayStr = Utilities.formatDate(now, 'Asia/Jakarta', 'yyyy-MM-dd');
  var totalOverdue = filteredRows.filter(function(r) {
    if (!r.CommitmentDate || r.StatusOrder !== 'OPEN') return false;
    var cd = String(r.CommitmentDate).slice(0, 10);
    return cd < todayStr && stages.slice(8).indexOf(String(r.Progres).toUpperCase()) === -1;
  }).length;

  var totalSelesai = filteredRows.filter(function(r) {
    return r.Progres && ['GOLIVE', 'PS', 'UJI TERIMA', 'REKON'].indexOf(String(r.Progres).toUpperCase()) >= 0;
  }).length;

  var totalOnTrack = totalAll - totalOverdue;
  if (totalOnTrack < 0) totalOnTrack = 0;

  var mitraStats = {};
  filteredRows.forEach(function(r) {
    if (!r.Mitra) return;
    var m = r.Mitra;
    if (!mitraStats[m]) mitraStats[m] = { total_minutes: 0, count: 0 };
    
    var isFinished = r.Progres && ['GOLIVE', 'PS', 'UJI TERIMA', 'REKON'].indexOf(String(r.Progres).toUpperCase()) >= 0;
    if (isFinished && r.CreatedAt && r.TanggalUpdateProgres) {
      var diffMs = Math.abs(new Date(r.TanggalUpdateProgres).getTime() - new Date(r.CreatedAt).getTime());
      var diffMinutes = Math.floor(diffMs / 60000);
      mitraStats[m].total_minutes += diffMinutes;
      mitraStats[m].count++;
    }
  });

  var mitraAvgArray = [];
  Object.keys(mitraStats).forEach(function(m) {
    var stats = mitraStats[m];
    if (stats.count > 0) {
      var avgMinutes = stats.total_minutes / stats.count;
      var avgDaysRaw = avgMinutes / 1440;
      
      var days = Math.floor(avgMinutes / 1440);
      var hours = Math.floor((avgMinutes % 1440) / 60);
      var labelStr = days + " Hari";
      if (hours > 0) labelStr += " " + hours + " Jam";

      var totalDays = Math.floor(stats.total_minutes / 1440);
      var totalHours = Math.floor((stats.total_minutes % 1440) / 60);
      var totalLabel = totalDays + " Hari";
      if (totalHours > 0) totalLabel += " " + totalHours + " Jam";

      mitraAvgArray.push({
        mitra: m,
        avg_raw: Math.round(avgDaysRaw * 100) / 100,
        avg_label: labelStr,
        count: stats.count,
        total_minutes: stats.total_minutes,
        total_label: totalLabel
      });
    }
  });

  mitraAvgArray.sort(function(a, b) { return b.avg_raw - a.avg_raw; });

  var mitraAvgLabels = [];
  var mitraAvgValues = [];
  var mitraAvgTextLabels = [];
  mitraAvgArray.forEach(function(item) {
    mitraAvgLabels.push(item.mitra);
    mitraAvgValues.push(item.avg_raw);
    mitraAvgTextLabels.push(item.avg_label);
  });

  var timelineData = [];
  var filterMitraArr = [];
  if (params && params.mitra) {
    if (Array.isArray(params.mitra)) {
      filterMitraArr = params.mitra;
    } else if (typeof params.mitra === 'string') {
      filterMitraArr = params.mitra.split(',').map(function(s) { return s.trim(); }).filter(Boolean);
    }
  }

  if (filterMitraArr.length > 0) {
    var logSh = getSheet(SHEET.LIVE_LOG);
    var logRows = sheetToObjects(logSh);
    
    var logsByOrder = {};
    logRows.forEach(function(log) {
      var key = log.StarClickID;
      if (!logsByOrder[key]) logsByOrder[key] = [];
      logsByOrder[key].push(log);
    });

    filterMitraArr.forEach(function(mitraName) {
      var orders = filteredRows.filter(function(r) {
        return String(r.Mitra).trim().toUpperCase() === String(mitraName).trim().toUpperCase();
      });
      var totalOrdersCount = orders.length;

      var transitions = [];
      for (var i = 0; i < stages.length - 1; i++) {
        transitions.push({ sum_minutes: 0, count: 0 });
      }

      orders.forEach(function(order) {
        var stagesTimes = {};
        if (order.CreatedAt) {
          stagesTimes['ON DESK'] = new Date(order.CreatedAt);
        }
        
        var oLogs = logsByOrder[order.StarClickID] || [];
        oLogs.forEach(function(l) {
          var stageName = String(l.Progres).trim().toUpperCase();
          if (!stagesTimes[stageName] && l.CreatedAt) {
            stagesTimes[stageName] = new Date(l.CreatedAt);
          }
        });

        for (var i = 0; i < stages.length - 1; i++) {
          var stageA = stages[i];
          var stageB = stages[i + 1];
          if (stagesTimes[stageA] && stagesTimes[stageB]) {
            var diffMin = Math.abs(stagesTimes[stageB].getTime() - stagesTimes[stageA].getTime()) / 60000;
            transitions[i].sum_minutes += diffMin;
            transitions[i].count++;
          }
        }
      });

      var steps = [];
      steps.push({
        stage: 'ON DESK',
        duration: 'Mulai',
        time: 'Referensi Awal',
        sample_size: totalOrdersCount
      });

      for (var i = 0; i < stages.length - 1; i++) {
        var stageB = stages[i + 1];
        var trans = transitions[i];
        if (trans.count > 0) {
          var avgMinutes = trans.sum_minutes / trans.count;
          var days = Math.floor(avgMinutes / 1440);
          var rem = Math.floor(avgMinutes % 1440);
          var hours = Math.floor(rem / 60);
          var mins = rem % 60;

          var durationLabel = "";
          if (days > 0) durationLabel += days + " hari";
          if (hours > 0) durationLabel += (durationLabel ? " " : "") + hours + " jam";
          if (mins > 0) durationLabel += (durationLabel ? " " : "") + mins + " menit";
          if (days === 0 && hours === 0 && mins === 0) durationLabel = "< 1 menit";

          steps.push({
            stage: stageB,
            duration: "+ " + durationLabel,
            time: "Rata-rata dari " + trans.count + " order",
            sample_size: trans.count
          });
        } else {
          steps.push({
            stage: stageB,
            duration: "N/A",
            time: "Tidak ada data",
            sample_size: 0
          });
        }
      }

      timelineData.push({
        mitra: mitraName,
        steps: steps,
        total_orders: totalOrdersCount
      });
    });
  }

  var overdueOrders = filteredRows.filter(function(r) {
    if (!r.CommitmentDate || r.StatusOrder !== 'OPEN') return false;
    var cd = String(r.CommitmentDate).slice(0, 10);
    return cd < todayStr && stages.slice(8).indexOf(String(r.Progres).toUpperCase()) === -1;
  });

  return {
    success: true,
    totalAll: totalAll,
    totalOverdue: totalOverdue,
    totalSelesai: totalSelesai,
    totalOnTrack: totalOnTrack,
    datelLabels: datelLabels,
    stackedData: stackedData,
    ihldStatuses: ihldStatuses,
    ihldStackedData: ihldStackedData,
    mitraAvgLabels: mitraAvgLabels,
    mitraAvgValues: mitraAvgValues,
    mitraAvgTextLabels: mitraAvgTextLabels,
    mitraAvgArray: mitraAvgArray,
    timelineData: timelineData,
    stoList: stoList,
    datelList: datelList,
    mitraList: mitraList,
    stages: stages,
    overdueOrders: overdueOrders.slice(0, 10).map(function(r) {
      return {
        id: r.ID,
        star_click_id: r.StarClickID,
        nama_customer: r.NamaCustomer,
        datel: r.Datel,
        commitment_date: r.CommitmentDate,
        updated_by: r.UpdatedBy
      };
    })
  };
}

function _matchFilter(rowVal, filterVal) {
  if (filterVal === undefined || filterVal === null || filterVal === '') return true;
  var target = String(rowVal || '').trim().toUpperCase();
  var values = [];
  if (Array.isArray(filterVal)) {
    values = filterVal;
  } else if (typeof filterVal === 'string') {
    values = filterVal.split(',').map(function(s) { return s.trim(); }).filter(Boolean);
  }
  if (values.length === 0) return true;
  return values.some(function(v) {
    return target === String(v).trim().toUpperCase();
  });
}

function _filterOverviewRows(rows, params) {
  if (!params) return rows;
  var year = params.year;
  var month = params.month;
  var dateFrom = params.date_from;
  var dateTo = params.date_to;
  var mitras = params.mitra;
  var stos = params.sto;
  var datels = params.datel;

  return rows.filter(function(r) {
    if (r.CreatedAt) {
      var dStr = String(r.CreatedAt).slice(0, 10);
      if (dateFrom || dateTo) {
        if (dateFrom && dStr < dateFrom) return false;
        if (dateTo && dStr > dateTo) return false;
      } else {
        if (year) {
          var y = String(r.CreatedAt).slice(0, 4);
          if (y !== String(year)) return false;
        }
        if (month && month !== 'all') {
          var m = String(r.CreatedAt).slice(5, 7);
          if (Number(m) !== Number(month)) return false;
        }
      }
    }
    if (!_matchFilter(r.Mitra, mitras)) return false;
    if (!_matchFilter(r.STO, stos)) return false;
    if (!_matchFilter(r.Datel, datels)) return false;
    return true;
  });
}

// ───────────────────────────────────────────────────────────
//  RESEED DATA — isi ulang data seed dengan data lengkap
// ───────────────────────────────────────────────────────────
function reseedData() {
  var ss = getSpreadsheet();

  // Reseed Deployment
  var sh = ss.getSheetByName(SHEET.DEPLOYMENT);
  if (sh && sh.getLastRow() > 1) {
    sh.deleteRows(2, sh.getLastRow() - 1);
  }
  _seedDeploymentData(sh);

  // Reseed LiveLog
  var logSh = ss.getSheetByName(SHEET.LIVE_LOG);
  if (logSh && logSh.getLastRow() > 1) {
    logSh.deleteRows(2, logSh.getLastRow() - 1);
  }
  _seedLiveLogData(logSh);

  return { success: true, message: '50 data deployment + 20 live log berhasil di-seed ulang' };
}

// ───────────────────────────────────────────────────────────
//  SETUP DATABASE — Buat spreadsheet & semua sheet
// ───────────────────────────────────────────────────────────
function setupDatabase() {
  var existingId = SCRIPT_PROPS.getProperty('SPREADSHEET_ID');
  var ss;

  if (existingId) {
    try {
      ss = SpreadsheetApp.openById(existingId);
      Logger.log('✅ Menggunakan spreadsheet yang sudah ada: ' + ss.getUrl());
    } catch (e) {
      existingId = null;
    }
  }

  if (!existingId) {
    ss = SpreadsheetApp.create('MONIKA — Database PT Telkom');
    SCRIPT_PROPS.setProperty('SPREADSHEET_ID', ss.getId());
    Logger.log('✅ Spreadsheet baru dibuat: ' + ss.getUrl());
  }

  _setupSheetDeployment(ss);
  _setupSheetEbisManualInput(ss);
  _setupSheetUsers(ss);
  _setupSheetLiveLog(ss);
  _setupSheetSettings(ss);
  _setupSheetDatels(ss);
  _setupSheetStos(ss);
  _setupSheetMitras(ss);

  // Hapus sheet default jika masih ada
  var defaultSheet = ss.getSheetByName('Sheet1');
  if (defaultSheet && ss.getSheets().length > 1) {
    ss.deleteSheet(defaultSheet);
  }

  Logger.log('🎉 Setup database selesai! URL: ' + ss.getUrl());
  Logger.log('📋 Spreadsheet ID: ' + ss.getId());
  return ss.getUrl();
}

function _setupSheetDeployment(ss) {
  var sh = ss.getSheetByName(SHEET.DEPLOYMENT);
  if (!sh) sh = ss.insertSheet(SHEET.DEPLOYMENT);

  var headers = [
    'ID', 'StarClickID', 'NamaCustomer', 'Datel', 'STO',
    'StatusOrder', 'TipeDesain', 'JenisProgram', 'Progres',
    'CommitmentDate', 'TanggalUpdateProgres', 'Mitra',
    'NamaProyek', 'Batch', 'CFU', 'StatusProyek',
    'StatusEProposal', 'StatusTomps', 'StatusSAP',
    'Regional', 'Witel', 'WOK', 'Segment',
    'UpdatedBy', 'CreatedAt', 'UpdatedAt',
    'TeleponPelanggan', 'AlamatPelanggan', 'TikorPelanggan'
  ];

  _writeHeaders(sh, headers, '#1a1a2e', '#ffffff');
}

function _setupSheetEbisManualInput(ss) {
  var sh = ss.getSheetByName(SHEET.EBIS_MANUAL_INPUT);
  if (!sh) sh = ss.insertSheet(SHEET.EBIS_MANUAL_INPUT);

  var headers = [
    'ID', 'StarClickID', 'NamaCustomer', 'Datel', 'STO', 'Mitra', 
    'NamaProyek', 'Batch', 'TeleponPelanggan', 'AlamatPelanggan', 'TikorPelanggan', 
    'Progres', 'StatusOrder', 'CommitmentDate', 'TanggalUpdateProgres', 
    'UpdatedBy', 'CreatedAt', 'UpdatedAt'
  ];

  _writeHeaders(sh, headers, '#1a1a2e', '#ffffff');
}

function _setupSheetUsers(ss) {
  var sh = ss.getSheetByName(SHEET.USERS);
  if (!sh) sh = ss.insertSheet(SHEET.USERS);

  var headers = [
    'ID', 'Nama', 'Email', 'Role', 'Status',
    'RequestedRole', 'NIK', 'Datel', 'CreatedAt', 'ApprovedAt'
  ];
  _writeHeaders(sh, headers, '#1a1a2e', '#ffffff');

  if (sh.getLastRow() <= 1) {
    _seedUserData(sh);
  }
}

function _setupSheetLiveLog(ss) {
  var sh = ss.getSheetByName(SHEET.LIVE_LOG);
  if (!sh) sh = ss.insertSheet(SHEET.LIVE_LOG);

  var headers = [
    'ID', 'DeploymentID', 'StarClickID', 'UserName',
    'Progres', 'CommitmentDate', 'Note', 'CreatedAt'
  ];
  _writeHeaders(sh, headers, '#1a1a2e', '#ffffff');

  if (sh.getLastRow() <= 1) {
    _seedLiveLogData(sh);
  }
}

function _setupSheetSettings(ss) {
  var sh = ss.getSheetByName(SHEET.SETTINGS);
  if (!sh) sh = ss.insertSheet(SHEET.SETTINGS);

  var headers = ['Key', 'Value', 'UpdatedAt'];
  _writeHeaders(sh, headers, '#1a1a2e', '#ffffff');

  if (sh.getLastRow() <= 1) {
    var now = new Date().toISOString();
    var defaults = [
      ['global_cap', '10', now],
      ['app_name', 'MONIKA', now],
      ['unit', 'Unit Optima · PT Telkom', now],
      ['overdue_threshold_days', '0', now]
    ];
    sh.getRange(2, 1, defaults.length, 3).setValues(defaults);
  }
}

function _writeHeaders(sheet, headers, bgColor, fontColor) {
  var range = sheet.getRange(1, 1, 1, headers.length);
  range.setValues([headers]);
  range.setBackground(bgColor);
  range.setFontColor(fontColor);
  range.setFontWeight('bold');
  range.setFontSize(10);
  sheet.setFrozenRows(1);
  sheet.getRange(1, 1, sheet.getMaxRows(), headers.length).setVerticalAlignment('middle');
}

// ───────────────────────────────────────────────────────────
//  SEED DATA
// ───────────────────────────────────────────────────────────
function _seedDeploymentData(sh) {
  var datels  = ['DATEL JAKARTA PUSAT','DATEL JAKARTA SELATAN','DATEL BANDUNG','DATEL SURABAYA','DATEL MEDAN'];
  var stos    = ['JKT001','JKT002','BDG001','SBY001','MDN001'];
  var progresses   = ['Survey','Desain','Material','Pemasangan','Testing','Rekon','-'];
  var statusOrders = ['OPEN','CLOSED','OPEN','OPEN','CLOSED','OPEN','CANCEL'];
  var mitras  = ['PT Mitra Andalan','CV Teknologi Nusantara','PT Infranet','PT Solusi Digital','CV Arya Mandiri'];
  var programs= ['REGULER','PROMO','KHUSUS'];
  var tipes   = ['FTTH','FTTB','FTTX'];
  var now     = new Date();
  var today   = Utilities.formatDate(now, 'Asia/Jakarta', 'yyyy-MM-dd');

  var rows = [];
  for (var i = 1; i <= 50; i++) {
    var daysAgo   = Math.floor(Math.random() * 60);
    var created   = new Date(now.getTime() - daysAgo * 86400000);
    var commitOff = Math.floor(Math.random() * 20) - 10; // +-10 hari dari hari ini
    var commitDate= new Date(now.getTime() + commitOff * 86400000);

    // TanggalUpdateProgres: 60% baris memiliki nilai (sebagian hari ini, sebagian kemarin/minggu ini)
    var updateDate = '';
    var rand = i % 5;
    if (rand === 0) {
      updateDate = today; // hari ini
    } else if (rand === 1) {
      var d = new Date(now.getTime() - 86400000);
      updateDate = Utilities.formatDate(d, 'Asia/Jakarta', 'yyyy-MM-dd'); // kemarin
    } else if (rand === 2) {
      var d = new Date(now.getTime() - 3 * 86400000);
      updateDate = Utilities.formatDate(d, 'Asia/Jakarta', 'yyyy-MM-dd'); // 3 hari lalu
    }
    // rand 3 & 4: kosong (belum diupdate)

    var status = statusOrders[i % statusOrders.length];
    var progres = progresses[i % progresses.length];

    rows.push([
      i,
      'SCK-2025-' + String(i).padStart(4, '0'),
      'PT CUSTOMER ' + String(i).padStart(3, '0'),
      datels[i % datels.length],
      stos[i % stos.length],
      status,
      tipes[i % tipes.length],
      programs[i % programs.length],
      progres,
      Utilities.formatDate(commitDate, 'Asia/Jakarta', 'yyyy-MM-dd'),
      updateDate,
      mitras[i % mitras.length],
      'PROYEK-' + String(i).padStart(3, '0'),
      'BATCH-0' + ((i % 5) + 1),
      i % 2 === 0 ? 'FIBER' : 'COPPER',
      i % 4 === 0 ? 'SELESAI' : 'PROGRESS',
      'APPROVED', 'DONE', 'POSTED',
      'REGIONAL 1',
      'WITEL JAKARTA',
      'WOK-JKT-0' + (i % 3 + 1),
      'ENTERPRISE',
      'admin@telkom.co.id',
      Utilities.formatDate(created, 'Asia/Jakarta', 'yyyy-MM-dd HH:mm:ss'),
      Utilities.formatDate(now, 'Asia/Jakarta', 'yyyy-MM-dd HH:mm:ss')
    ]);
  }
  sh.getRange(2, 1, rows.length, rows[0].length).setValues(rows);
}

function _seedUserData(sh) {
  var now = new Date().toISOString();
  var users = [
    [1, 'Admin Telkom', 'admin@telkom.co.id', 'admin', 'active', '', '1001', 'PUSAT', now, now],
    [2, 'Budi Santoso', 'budi@telkom.co.id', 'optima', 'active', 'optima', '1002', 'DATEL JAKARTA PUSAT', now, now],
    [3, 'Siti Rahayu', 'siti@telkom.co.id', 'optima', 'waiting', 'optima', '1003', 'DATEL BANDUNG', now, ''],
    [4, 'Ahmad Fauzi', 'ahmad@telkom.co.id', 'optima', 'waiting', 'optima', '1004', 'DATEL SURABAYA', now, ''],
    [5, 'Dewi Lestari', 'dewi@telkom.co.id', 'optima', 'active', 'optima', '1005', 'DATEL MEDAN', now, now]
  ];
  sh.getRange(2, 1, users.length, users[0].length).setValues(users);
}

function _seedLiveLogData(sh) {
  var now = new Date();
  var users = ['Budi Santoso', 'Dewi Lestari', 'Ahmad Fauzi'];
  var progresses = ['Survey', 'Desain', 'Material', 'Pemasangan', 'Rekon'];
  var rows = [];
  for (var i = 1; i <= 20; i++) {
    var minutesAgo = i * 5;
    var ts = new Date(now.getTime() - minutesAgo * 60000);
    rows.push([
      i,
      i,
      'SCK-2025-' + String(i).padStart(4, '0'),
      users[i % users.length],
      progresses[i % progresses.length],
      Utilities.formatDate(new Date(now.getTime() + 7 * 86400000), 'Asia/Jakarta', 'yyyy-MM-dd'),
      'Update progres order',
      Utilities.formatDate(ts, 'Asia/Jakarta', 'yyyy-MM-dd HH:mm:ss')
    ]);
  }
  sh.getRange(2, 1, rows.length, rows[0].length).setValues(rows);
}

// ───────────────────────────────────────────────────────────
//  HELPER — Ambil spreadsheet & sheet (dengan global caching)
// ───────────────────────────────────────────────────────────
function getSpreadsheet() {
  if (_cachedSpreadsheet) return _cachedSpreadsheet;
  _perfStats.openByIdCalls++;
  var id = SCRIPT_PROPS.getProperty('SPREADSHEET_ID');
  if (!id) throw new Error('Database belum di-setup. Jalankan setupDatabase() terlebih dahulu.');
  _cachedSpreadsheet = SpreadsheetApp.openById(id);
  return _cachedSpreadsheet;
}

function getSheet(name) {
  _perfStats.getSheetCalls++;
  if (_cachedSheets[name]) return _cachedSheets[name];
  var ss = getSpreadsheet();
  if (!ss) return null;
  _cachedSheets[name] = ss.getSheetByName(name);
  return _cachedSheets[name];
}

function sheetToObjects(sh, startRow) {
  if (!sh) return [];
  var name = sh.getName();
  var startRowVal = startRow || 2;
  var cacheKey = name + '_' + startRowVal;
  if (_cachedSheetData[cacheKey]) return _cachedSheetData[cacheKey];

  _perfStats.sheetReads++;
  var values = sh.getDataRange().getValues();
  _perfStats.rowsCount[name] = values.length;
  if (values.length < startRowVal) return [];
  var headers = values[0];
  var data    = values.slice(startRowVal - 1);
  var result = data.map(function(row) {
    var obj = {};
    headers.forEach(function(h, i) { obj[h] = row[i]; });
    return obj;
  });
  _cachedSheetData[cacheKey] = result;
  return result;
}

function nextId(sh) {
  var values = sh.getDataRange().getValues();
  if (values.length < 2) return 1;
  var ids = values.slice(1).map(function(r) { return Number(r[0]) || 0; });
  return Math.max.apply(null, ids) + 1;
}

function getMergedDeployments() {
  var manualSh = getSheet(SHEET.EBIS_MANUAL_INPUT);
  var depSh    = getSheet(SHEET.DEPLOYMENT);
  
  var manualRows = sheetToObjects(manualSh);
  var depRows    = sheetToObjects(depSh);
  
  var depMap = {};
  depRows.forEach(function(r) {
    if (r.StarClickID) {
      depMap[String(r.StarClickID).trim().toUpperCase()] = r;
    }
  });
  
  return manualRows.map(function(m) {
    var key = String(m.StarClickID || '').trim().toUpperCase();
    var dep = depMap[key] || {};
    
    var merged = {};
    
    // Copy deployment properties first
    Object.keys(dep).forEach(function(k) {
      merged[k] = dep[k];
    });
    
    // Copy manual input properties (primary)
    Object.keys(m).forEach(function(k) {
      if (m[k] !== undefined && m[k] !== null && m[k] !== '') {
        merged[k] = m[k];
      } else if (merged[k] === undefined || merged[k] === null || merged[k] === '') {
        merged[k] = m[k];
      }
    });
    
    merged.ID = m.ID;
    
    if (!merged.StatusOrder) {
      merged.StatusOrder = 'OPEN';
    }
    
    return merged;
  });
}

function getCurrentUser() {
  try {
    return Session.getActiveUser().getEmail() || 'guest@telkom.co.id';
  } catch(e) {
    return 'guest@telkom.co.id';
  }
}

// ───────────────────────────────────────────────────────────
//  DASHBOARD STATS
// ───────────────────────────────────────────────────────────
function getDashboardStats() {
  var rows = getMergedDeployments();
  var now  = new Date();

  var total      = rows.length;
  var onProgress = rows.filter(function(r) { return r.StatusOrder === 'OPEN'; }).length;
  var completed  = rows.filter(function(r) { return r.StatusOrder === 'CLOSED'; }).length;
  var cancelled  = rows.filter(function(r) { return r.StatusOrder === 'CANCEL'; }).length;

  // Overdue: CommitmentDate sudah lewat dan progres bukan rekon
  var overdue = rows.filter(function(r) {
    if (!r.CommitmentDate) return false;
    var cd = new Date(r.CommitmentDate);
    return cd < now && r.Progres !== 'Rekon' && r.StatusOrder === 'OPEN';
  });

  // Waiting users
  var userSh       = getSheet(SHEET.USERS);
  var users        = sheetToObjects(userSh);
  var waitingUsers = users.filter(function(u) { return u.Status === 'waiting'; });

  // Today's input
  var today        = Utilities.formatDate(now, 'Asia/Jakarta', 'yyyy-MM-dd');
  var todayEntries = rows.filter(function(r) {
    return r.CreatedAt && String(r.CreatedAt).slice(0, 10) === today;
  }).length;

  return {
    success      : true,
    total        : total,
    onProgress   : onProgress,
    completed    : completed,
    cancelled    : cancelled,
    overdueCount : overdue.length,
    overdueItems : overdue.slice(0, 10).map(function(r) {
      var cd   = new Date(r.CommitmentDate);
      var diff = Math.floor((now - cd) / 86400000);
      return {
        id            : r.ID,
        star_click_id : r.StarClickID,
        nama_customer : r.NamaCustomer,
        datel         : r.Datel,
        commitment_date : r.CommitmentDate,
        days_overdue  : diff,
        status        : r.StatusOrder,
        updated_by    : r.UpdatedBy
      };
    }),
    waitingUsers : waitingUsers.map(function(u) {
      return {
        id            : u.ID,
        name          : u.Nama,
        email         : u.Email,
        requested_role: u.RequestedRole,
        created_at    : u.CreatedAt
      };
    }),
    todayEntries : todayEntries
  };
}

// ───────────────────────────────────────────────────────────
//  TREND DATA
// ───────────────────────────────────────────────────────────
function getTrendData(params) {
  var filter = params.filter || 'monthly';
  var datel  = params.datel  || '';
  var sto    = params.sto    || '';
  var mitra  = params.mitra  || '';

  var rows = getMergedDeployments();

  // Filter
  if (datel) rows = rows.filter(function(r) { return r.Datel === datel; });
  if (sto)   rows = rows.filter(function(r) { return r.STO   === sto;   });
  if (mitra) rows = rows.filter(function(r) { return r.Mitra === mitra; });

  var grouped = {};
  var now     = new Date();

  rows.forEach(function(r) {
    if (!r.CreatedAt) return;
    var d   = new Date(r.CreatedAt);
    var key = '';
    if (filter === 'daily') {
      key = Utilities.formatDate(d, 'Asia/Jakarta', 'dd MMM');
    } else if (filter === 'weekly') {
      var wk  = Math.ceil(d.getDate() / 7);
      key = 'W' + wk + ' ' + Utilities.formatDate(d, 'Asia/Jakarta', 'MMM yyyy');
    } else {
      key = Utilities.formatDate(d, 'Asia/Jakarta', 'MMM yyyy');
    }
    grouped[key] = (grouped[key] || 0) + 1;
  });

  // Generate last-N buckets
  var labels = [], values = [];
  if (filter === 'daily') {
    for (var i = 13; i >= 0; i--) {
      var d2  = new Date(now.getTime() - i * 86400000);
      var lbl = Utilities.formatDate(d2, 'Asia/Jakarta', 'dd MMM');
      labels.push(lbl);
      values.push(grouped[lbl] || 0);
    }
  } else if (filter === 'weekly') {
    for (var i = 7; i >= 0; i--) {
      var d2  = new Date(now.getTime() - i * 7 * 86400000);
      var wk  = Math.ceil(d2.getDate() / 7);
      var lbl = 'W' + wk + ' ' + Utilities.formatDate(d2, 'Asia/Jakarta', 'MMM yyyy');
      labels.push(lbl);
      values.push(grouped[lbl] || 0);
    }
  } else {
    for (var i = 11; i >= 0; i--) {
      var d2 = new Date(now.getFullYear(), now.getMonth() - i, 1);
      var lbl = Utilities.formatDate(d2, 'Asia/Jakarta', 'MMM yyyy');
      labels.push(lbl);
      values.push(grouped[lbl] || 0);
    }
  }

  return { success: true, labels: labels, values: values };
}

// ───────────────────────────────────────────────────────────
//  TOP MITRAS
// ───────────────────────────────────────────────────────────
function getTopMitras(params) {
  var rows = getMergedDeployments();
  
  var now = new Date();
  var todayStr = Utilities.formatDate(now, 'Asia/Jakarta', 'yyyy-MM-dd');
  
  // start of week helper (Senin)
  var startOfWeek = new Date(now);
  var day = startOfWeek.getDay();
  var diff = startOfWeek.getDate() - day + (day === 0 ? -6 : 1);
  startOfWeek.setDate(diff);
  var startOfWeekStr = Utilities.formatDate(startOfWeek, 'Asia/Jakarta', 'yyyy-MM-dd');
  
  var currentMonth = now.getMonth();
  var currentYear = now.getFullYear();
  
  var daily_cap = 3;
  var weekly_cap = 15;
  var monthly_cap = 60;
  
  var mitraMap = {};
  
  rows.forEach(function(r) {
    if (!r.Mitra) return;
    var m = r.Mitra;
    if (!mitraMap[m]) {
      mitraMap[m] = {
        name: m,
        total: 0,
        daily: 0,
        weekly: 0,
        monthly: 0,
        total_days: 0,
        days_count: 0
      };
    }
    
    mitraMap[m].total++;
    
    if (r.CreatedAt) {
      var dStr = String(r.CreatedAt).slice(0, 10);
      var cDate = new Date(r.CreatedAt);
      
      // Daily
      if (dStr === todayStr) {
        mitraMap[m].daily++;
      }
      // Weekly
      if (dStr >= startOfWeekStr && dStr <= todayStr) {
        mitraMap[m].weekly++;
      }
      // Monthly
      if (cDate.getMonth() === currentMonth && cDate.getFullYear() === currentYear) {
        mitraMap[m].monthly++;
      }
    }
    
    // avg_time
    if (r.CreatedAt && r.TanggalUpdateProgres) {
      var diffMs = Math.abs(new Date(r.TanggalUpdateProgres).getTime() - new Date(r.CreatedAt).getTime());
      var diffDays = diffMs / (1000 * 60 * 60 * 24);
      mitraMap[m].total_days += diffDays;
      mitraMap[m].days_count++;
    }
  });
  
  var result = Object.keys(mitraMap).map(function(name) {
    var m = mitraMap[name];
    var avg = m.days_count > 0 ? Math.round(m.total_days / m.days_count) : 0;
    return {
      name: m.name,
      total: m.total,
      daily: m.daily,
      weekly: m.weekly,
      monthly: m.monthly,
      daily_cap: daily_cap,
      weekly_cap: weekly_cap,
      monthly_cap: monthly_cap,
      avg_time: avg + ' hari'
    };
  });
  
  result.sort(function(a, b) { return b.total - a.total; });
  return result.slice(0, 5);
}


// ───────────────────────────────────────────────────────────
//  WORKLOAD DAY
// ───────────────────────────────────────────────────────────
function getWorkloadDay(params) {
  var year  = parseInt(params.year  || new Date().getFullYear());
  var month = parseInt(params.month || (new Date().getMonth() + 1));
  var rows  = getMergedDeployments();

  // Filter bulan
  var prefix = year + '-' + String(month).padStart(2, '0');
  var monthRows = rows.filter(function(r) {
    return r.TanggalUpdateProgres && String(r.TanggalUpdateProgres).startsWith(prefix);
  });

  // Group by date + mitra
  var dayMap = {};
  monthRows.forEach(function(r) {
    var day   = String(r.TanggalUpdateProgres).slice(0, 10);
    var mitra = r.Mitra || 'Tanpa Mitra';
    if (!dayMap[day]) dayMap[day] = {};
    if (!dayMap[day][mitra]) dayMap[day][mitra] = { count: 0, stages: [] };
    dayMap[day][mitra].count++;
    if (r.Progres && dayMap[day][mitra].stages.indexOf(r.Progres) === -1) {
      dayMap[day][mitra].stages.push(r.Progres);
    }
  });

  // Build calendar grid (start Monday)
  var firstDay = new Date(year, month - 1, 1);
  var lastDay  = new Date(year, month, 0);
  var today    = Utilities.formatDate(new Date(), 'Asia/Jakarta', 'yyyy-MM-dd');

  // Offset start to Monday
  var startOffset = (firstDay.getDay() + 6) % 7;
  var grid = [];

  // Pad before
  for (var i = startOffset; i > 0; i--) {
    var d = new Date(firstDay.getTime() - i * 86400000);
    grid.push(_buildCalDay(d, dayMap, today, false));
  }
  // Days in month
  for (var d2 = 1; d2 <= lastDay.getDate(); d2++) {
    var dt = new Date(year, month - 1, d2);
    grid.push(_buildCalDay(dt, dayMap, today, true));
  }
  // Pad after to complete week
  var remaining = (7 - (grid.length % 7)) % 7;
  for (var i = 1; i <= remaining; i++) {
    var d = new Date(lastDay.getTime() + i * 86400000);
    grid.push(_buildCalDay(d, dayMap, today, false));
  }

  var settings  = getSettingsMap();
  var globalCap = parseInt(settings.global_cap || '10');

  return { success: true, week_headers: grid, global_cap: globalCap };
}

function _buildCalDay(date, dayMap, today, inMonth) {
  var days  = ['MIN', 'SEN', 'SEL', 'RAB', 'KAM', 'JUM', 'SAB'];
  var mons  = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
  var key   = Utilities.formatDate(date, 'Asia/Jakarta', 'yyyy-MM-dd');
  var dayData = dayMap[key] || {};
  var details = Object.keys(dayData).map(function(mitra) {
    return { mitra: mitra, count: dayData[mitra].count, stages: dayData[mitra].stages };
  });
  var totalCount = details.reduce(function(s, d) { return s + d.count; }, 0);

  return {
    date      : key,
    num_label : date.getDate() + ' ' + mons[date.getMonth()] + ' ' + date.getFullYear(),
    day_label : days[date.getDay()],
    in_month  : inMonth,
    is_today  : key === today,
    count     : totalCount,
    details   : details
  };
}

// ───────────────────────────────────────────────────────────
//  LIVE TRACKING
// ───────────────────────────────────────────────────────────
function getLiveTracking() {
  var sh   = getSheet(SHEET.LIVE_LOG);
  var rows = sheetToObjects(sh);

  rows.sort(function(a, b) { return new Date(b.CreatedAt) - new Date(a.CreatedAt); });

  return {
    success : true,
    data    : rows.slice(0, 20).map(function(r) {
      return {
        id             : r.ID,
        deployment_id  : r.DeploymentID,
        star_click_id  : r.StarClickID,
        user_name      : r.UserName,
        progres        : r.Progres,
        commitment_date: r.CommitmentDate,
        note           : r.Note,
        created_at     : r.CreatedAt
      };
    })
  };
}

// ───────────────────────────────────────────────────────────
//  DEPLOYMENTS CRUD
// ───────────────────────────────────────────────────────────
function getDeployments(params) {
  var rows  = getMergedDeployments();
  var search= (params.search || '').toLowerCase();
  var datel = params.datel  || '';
  var sto   = params.sto    || '';
  var progres = params.progres || '';
  var page  = parseInt(params.page  || 1);
  var limit = parseInt(params.limit || 10);

  if (search) {
    rows = rows.filter(function(r) {
      return (String(r.StarClickID).toLowerCase().includes(search)  ||
              String(r.NamaCustomer).toLowerCase().includes(search) ||
              String(r.Datel).toLowerCase().includes(search)        ||
              String(r.STO).toLowerCase().includes(search));
    });
  }
  if (datel)  rows = rows.filter(function(r) { return r.Datel   === datel;  });
  if (sto)    rows = rows.filter(function(r) { return r.STO     === sto;    });
  if (progres)rows = rows.filter(function(r) { return r.Progres === progres;});

  rows.sort(function(a, b) { return Number(b.ID) - Number(a.ID); });

  var total = rows.length;
  var sliced = rows.slice((page - 1) * limit, page * limit);

  return {
    success   : true,
    data      : sliced,
    total     : total,
    page      : page,
    totalPages: Math.ceil(total / limit)
  };
}

function addDeployment(params) {
  var sh  = getSheet(SHEET.EBIS_MANUAL_INPUT);
  var id  = nextId(sh);
  var now = Utilities.formatDate(new Date(), 'Asia/Jakarta', 'yyyy-MM-dd HH:mm:ss');

  var row = [
    id,
    params.StarClickID      || '',
    params.NamaCustomer     || '',
    params.Datel            || '',
    params.STO              || '',
    params.Mitra            || '',
    params.NamaProyek       || '',
    params.Batch            || '',
    params.TeleponPelanggan || '',
    params.AlamatPelanggan  || '',
    params.TikorPelanggan   || '',
    params.Progres          || '-',
    params.StatusOrder      || 'OPEN',
    params.CommitmentDate   || '',
    '', // TanggalUpdateProgres
    getCurrentUser(),
    now,
    now
  ];

  sh.appendRow(row);
  _appendLog(id, params.StarClickID || '', params.Progres || '-', params.CommitmentDate || '');
  return { success: true, id: id, message: 'Data berhasil ditambahkan' };
}

function updateDeployment(params) {
  var sh   = getSheet(SHEET.EBIS_MANUAL_INPUT);
  var data = sh.getDataRange().getValues();
  if (data.length < 1) return { success: false, message: 'Sheet kosong' };
  
  var headers = data[0];
  var idxId = headers.indexOf('ID');
  var idxStar = headers.indexOf('StarClickID');
  var idxStatus = headers.indexOf('StatusOrder');
  var idxProg = headers.indexOf('Progres');
  var idxCommit = headers.indexOf('CommitmentDate');
  var idxTglUpdate = headers.indexOf('TanggalUpdateProgres');
  var idxMitra = headers.indexOf('Mitra');
  var idxUser = headers.indexOf('UpdatedBy');
  var idxUpdated = headers.indexOf('UpdatedAt');
  
  var now  = Utilities.formatDate(new Date(), 'Asia/Jakarta', 'yyyy-MM-dd HH:mm:ss');
  var id   = parseInt(params.ID);

  for (var i = 1; i < data.length; i++) {
    if (parseInt(data[i][idxId]) === id) {
      var row = data[i];
      if (params.StatusOrder && idxStatus !== -1) row[idxStatus] = params.StatusOrder;
      if (params.Progres && idxProg !== -1)       row[idxProg]   = params.Progres;
      if (params.CommitmentDate && idxCommit !== -1) row[idxCommit] = params.CommitmentDate;
      if (params.TanggalUpdate && idxTglUpdate !== -1) row[idxTglUpdate] = params.TanggalUpdate;
      if (params.Mitra && idxMitra !== -1)         row[idxMitra]  = params.Mitra;
      if (idxUser !== -1)                          row[idxUser]   = getCurrentUser();
      if (idxUpdated !== -1)                       row[idxUpdated] = now;

      sh.getRange(i + 1, 1, 1, row.length).setValues([row]);
      _appendLog(id, String(row[idxStar || 1]), String(params.Progres || row[idxProg]), String(params.CommitmentDate || row[idxCommit]));
      return { success: true, message: 'Data berhasil diperbarui' };
    }
  }
  return { success: false, message: 'Data tidak ditemukan' };
}

function deleteDeployment(params) {
  var sh   = getSheet(SHEET.EBIS_MANUAL_INPUT);
  var data = sh.getDataRange().getValues();
  if (data.length < 1) return { success: false, message: 'Sheet kosong' };
  
  var headers = data[0];
  var idxId = headers.indexOf('ID');
  var id   = parseInt(params.ID);

  for (var i = 1; i < data.length; i++) {
    if (parseInt(data[i][idxId]) === id) {
      sh.deleteRow(i + 1);
      return { success: true, message: 'Data berhasil dihapus' };
    }
  }
  return { success: false, message: 'Data tidak ditemukan' };
}

function importDeployments(params) {
  // Import via JSON string (dari CSV yang di-parse di client)
  if (!params.data) return { success: false, message: 'Data kosong' };
  try {
    var rows   = JSON.parse(params.data);
    var sh     = getSheet(SHEET.DEPLOYMENT);
    var now    = Utilities.formatDate(new Date(), 'Asia/Jakarta', 'yyyy-MM-dd HH:mm:ss');
    var lastId = nextId(sh) - 1;

    var toAppend = rows.map(function(r, i) {
      return [
        lastId + i + 1,
        r.StarClickID    || '',
        r.NamaCustomer   || '',
        r.Datel          || '',
        r.STO            || '',
        r.StatusOrder    || 'OPEN',
        r.TipeDesain     || '',
        r.JenisProgram   || '',
        r.Progres        || '-',
        r.CommitmentDate || '',
        r.TanggalUpdateProgres || '',
        r.Mitra          || '',
        r.NamaProyek     || '',
        r.Batch          || '',
        r.CFU            || '',
        r.StatusProyek   || '',
        r.StatusEProposal|| '',
        r.StatusTomps    || '',
        r.StatusSAP      || '',
        r.Regional       || '',
        r.Witel          || '',
        r.WOK            || '',
        r.Segment        || '',
        getCurrentUser(), now, now,
        r.TeleponPelanggan || '',
        r.AlamatPelanggan  || '',
        r.TikorPelanggan   || ''
      ];
    });

    if (toAppend.length > 0) {
      sh.getRange(sh.getLastRow() + 1, 1, toAppend.length, toAppend[0].length).setValues(toAppend);
    }
    return { success: true, count: toAppend.length, message: toAppend.length + ' data berhasil diimport' };
  } catch (e) {
    return { success: false, message: 'Format data tidak valid: ' + e.message };
  }
}

function _appendLog(depId, starClickId, progres, commitDate) {
  var sh  = getSheet(SHEET.LIVE_LOG);
  var id  = nextId(sh);
  var now = Utilities.formatDate(new Date(), 'Asia/Jakarta', 'yyyy-MM-dd HH:mm:ss');
  sh.appendRow([id, depId, starClickId, getCurrentUser(), progres, commitDate, 'Update progres', now]);
}

// ───────────────────────────────────────────────────────────
//  USERS
// ───────────────────────────────────────────────────────────
function getUsers() {
  var sh   = getSheet(SHEET.USERS);
  var rows = sheetToObjects(sh);
  return { success: true, data: rows };
}

function approveUser(params) {
  var sh   = getSheet(SHEET.USERS);
  var data = sh.getDataRange().getValues();
  var id   = parseInt(params.ID);
  var role = params.role || 'optima';
  var now  = Utilities.formatDate(new Date(), 'Asia/Jakarta', 'yyyy-MM-dd HH:mm:ss');

  for (var i = 1; i < data.length; i++) {
    if (parseInt(data[i][0]) === id) {
      data[i][3] = role;
      data[i][4] = 'active';
      data[i][9] = now;
      sh.getRange(i + 1, 1, 1, data[i].length).setValues([data[i]]);
      return { success: true, message: 'User berhasil di-approve' };
    }
  }
  return { success: false, message: 'User tidak ditemukan' };
}

function updateUserRole(params) {
  return approveUser(params);
}

function addUser(params) {
  var sh  = getSheet(SHEET.USERS);
  var id  = nextId(sh);
  var now = Utilities.formatDate(new Date(), 'Asia/Jakarta', 'yyyy-MM-dd HH:mm:ss');
  sh.appendRow([
    id, params.Nama || '', params.Email || '',
    params.Role || 'optima', 'active',
    params.Role || 'optima',
    params.NIK  || '', params.Datel || '',
    now, now
  ]);
  return { success: true, id: id, message: 'User berhasil ditambahkan' };
}

function deleteUser(params) {
  var sh   = getSheet(SHEET.USERS);
  var data = sh.getDataRange().getValues();
  var id   = parseInt(params.ID);
  for (var i = 1; i < data.length; i++) {
    if (parseInt(data[i][0]) === id) {
      sh.deleteRow(i + 1);
      return { success: true, message: 'User berhasil dihapus' };
    }
  }
  return { success: false, message: 'User tidak ditemukan' };
}

// ───────────────────────────────────────────────────────────
//  SETTINGS
// ───────────────────────────────────────────────────────────
function getSettingsMap() {
  var sh   = getSheet(SHEET.SETTINGS);
  if (!sh) return {};
  var rows = sheetToObjects(sh);
  var map  = {};
  rows.forEach(function(r) { map[r.Key] = r.Value; });
  return map;
}

function getSettings() {
  return { success: true, data: getSettingsMap() };
}

function saveSettings(params) {
  var sh   = getSheet(SHEET.SETTINGS);
  var data = sh.getDataRange().getValues();
  var now  = Utilities.formatDate(new Date(), 'Asia/Jakarta', 'yyyy-MM-dd HH:mm:ss');
  var keys = Object.keys(params).filter(function(k) { return k !== 'action'; });

  keys.forEach(function(key) {
    var found = false;
    for (var i = 1; i < data.length; i++) {
      if (data[i][0] === key) {
        sh.getRange(i + 1, 2, 1, 2).setValues([[params[key], now]]);
        found = true;
        break;
      }
    }
    if (!found) {
      sh.appendRow([key, params[key], now]);
    }
  });
  return { success: true, message: 'Pengaturan berhasil disimpan' };
}

// ───────────────────────────────────────────────────────────
//  FILTER OPTIONS
// ───────────────────────────────────────────────────────────
function getFilterOptions() {
  var shDatels = getSheet(SHEET.DATELS);
  var shStos = getSheet(SHEET.STOS);
  var shMitras = getSheet(SHEET.MITRAS);
  
  var datels = shDatels ? sheetToObjects(shDatels).map(function(r) { return r.NamaDatel; }) : [];
  var stos = shStos ? sheetToObjects(shStos).map(function(r) { return r.NamaSto; }) : [];
  var mitras = shMitras ? sheetToObjects(shMitras).map(function(r) { return r.NamaMitra; }) : [];
  
  var depRows = getMergedDeployments();

  var unique = function(arr) {
    var seen = {}, out = [];
    arr.forEach(function(v) { if (v && !seen[v]) { seen[v] = true; out.push(v); } });
    return out.sort();
  };

  return {
    success : true,
    datels  : unique(datels.length > 0 ? datels : depRows.map(function(r) { return r.Datel; })),
    stos    : unique(stos.length > 0 ? stos : depRows.map(function(r) { return r.STO; })),
    mitras  : unique(mitras.length > 0 ? mitras : depRows.map(function(r) { return r.Mitra; })),
    progresses: unique(depRows.map(function(r) { return r.Progres;})),
    batches : unique(depRows.map(function(r) { return r.Batch;   }))
  };
}

// ───────────────────────────────────────────────────────────
//  MASTER DATA SCHEMA SETUP
// ───────────────────────────────────────────────────────────
function _setupSheetDatels(ss) {
  var sh = ss.getSheetByName(SHEET.DATELS);
  if (!sh) sh = ss.insertSheet(SHEET.DATELS);
  var headers = ['ID', 'NamaDatel'];
  _writeHeaders(sh, headers, '#1a1a2e', '#ffffff');
  if (sh.getLastRow() <= 1) {
    var defaults = [
      [1, 'DATEL JAKARTA PUSAT'],
      [2, 'DATEL BANDUNG'],
      [3, 'DATEL SURABAYA']
    ];
    sh.getRange(2, 1, defaults.length, 2).setValues(defaults);
  }
}

function _setupSheetStos(ss) {
  var sh = ss.getSheetByName(SHEET.STOS);
  if (!sh) sh = ss.insertSheet(SHEET.STOS);
  var headers = ['ID', 'NamaSto'];
  _writeHeaders(sh, headers, '#1a1a2e', '#ffffff');
  if (sh.getLastRow() <= 1) {
    var defaults = [
      [1, 'JKT01'],
      [2, 'BDG01'],
      [3, 'SBY01']
    ];
    sh.getRange(2, 1, defaults.length, 2).setValues(defaults);
  }
}

function _setupSheetMitras(ss) {
  var sh = ss.getSheetByName(SHEET.MITRAS);
  if (!sh) sh = ss.insertSheet(SHEET.MITRAS);
  var headers = ['ID', 'NamaMitra'];
  _writeHeaders(sh, headers, '#1a1a2e', '#ffffff');
  if (sh.getLastRow() <= 1) {
    var defaults = [
      [1, 'PT INFRANET'],
      [2, 'PT TELKOM AKSES'],
      [3, 'PT KARYA INDAH']
    ];
    sh.getRange(2, 1, defaults.length, 2).setValues(defaults);
  }
}

// ───────────────────────────────────────────────────────────
//  MASTER DATA CRUD
// ───────────────────────────────────────────────────────────
function getMasterData() {
  var shDatels = getSheet(SHEET.DATELS);
  var shStos = getSheet(SHEET.STOS);
  var shMitras = getSheet(SHEET.MITRAS);
  
  var datels = shDatels ? sheetToObjects(shDatels) : [];
  var stos = shStos ? sheetToObjects(shStos) : [];
  var mitras = shMitras ? sheetToObjects(shMitras) : [];
  
  return {
    success: true,
    datels: datels,
    stos: stos,
    mitras: mitras
  };
}

function addMasterItem(params) {
  var type = params.type || ''; 
  var name = (params.name || '').toUpperCase().trim();
  if (!type || !name) return { success: false, message: 'Tipe atau nama tidak boleh kosong' };
  
  var sheetName = '';
  var headerName = '';
  if (type === 'datels') { sheetName = SHEET.DATELS; headerName = 'NamaDatel'; }
  else if (type === 'stos') { sheetName = SHEET.STOS; headerName = 'NamaSto'; }
  else if (type === 'mitras') { sheetName = SHEET.MITRAS; headerName = 'NamaMitra'; }
  else { return { success: false, message: 'Tipe master data tidak dikenal' }; }
  
  var sh = getSheet(sheetName);
  if (!sh) return { success: false, message: 'Sheet master tidak ditemukan. Jalankan Setup Database.' };
  
  var rows = sheetToObjects(sh);
  
  var exists = rows.some(function(r) {
    return String(r[headerName]).toUpperCase().trim() === name;
  });
  if (exists) return { success: false, message: name + ' sudah ada!' };
  
  var id = nextId(sh);
  sh.appendRow([id, name]);
  return { success: true, message: 'Item berhasil ditambahkan', item: { ID: id, name: name } };
}

function updateMasterItem(params) {
  var type = params.type || ''; 
  var id = Number(params.id);
  var newName = (params.name || '').toUpperCase().trim();
  if (!type || !id || !newName) return { success: false, message: 'Data tidak lengkap' };
  
  var sheetName = '';
  var headerName = '';
  var colIndexInDeployment = -1; 
  if (type === 'datels') { sheetName = SHEET.DATELS; headerName = 'NamaDatel'; colIndexInDeployment = 4; } 
  else if (type === 'stos') { sheetName = SHEET.STOS; headerName = 'NamaSto'; colIndexInDeployment = 5; } 
  else if (type === 'mitras') { sheetName = SHEET.MITRAS; headerName = 'NamaMitra'; colIndexInDeployment = 12; } 
  else { return { success: false, message: 'Tipe master data tidak dikenal' }; }
  
  var sh = getSheet(sheetName);
  if (!sh) return { success: false, message: 'Sheet master tidak ditemukan' };
  
  var lastRow = sh.getLastRow();
  if (lastRow < 2) return { success: false, message: 'Item tidak ditemukan' };
  
  var ids = sh.getRange(2, 1, lastRow - 1, 1).getValues().map(function(r) { return Number(r[0]); });
  var rowIndex = ids.indexOf(id);
  if (rowIndex === -1) return { success: false, message: 'Item tidak ditemukan' };
  
  var oldName = sh.getRange(rowIndex + 2, 2).getValue();
  sh.getRange(rowIndex + 2, 2).setValue(newName);
  
  if (oldName && oldName !== newName && colIndexInDeployment !== -1) {
    var depSh = getSheet(SHEET.DEPLOYMENT);
    var depLastRow = depSh.getLastRow();
    if (depLastRow > 1) {
      var values = depSh.getRange(2, colIndexInDeployment, depLastRow - 1, 1).getValues();
      var updated = false;
      for (var i = 0; i < values.length; i++) {
        if (values[i][0] === oldName) {
          values[i][0] = newName;
          updated = true;
        }
      }
      if (updated) {
        depSh.getRange(2, colIndexInDeployment, depLastRow - 1, 1).setValues(values);
      }
    }
  }
  
  return { success: true, message: 'Item berhasil diperbarui' };
}

function deleteMasterItem(params) {
  var type = params.type || ''; 
  var id = Number(params.id);
  if (!type || !id) return { success: false, message: 'Data tidak lengkap' };
  
  var sheetName = '';
  if (type === 'datels') sheetName = SHEET.DATELS;
  else if (type === 'stos') sheetName = SHEET.STOS;
  else if (type === 'mitras') sheetName = SHEET.MITRAS;
  else return { success: false, message: 'Tipe master data tidak dikenal' };
  
  var sh = getSheet(sheetName);
  if (!sh) return { success: false, message: 'Sheet master tidak ditemukan' };
  
  var lastRow = sh.getLastRow();
  if (lastRow < 2) return { success: false, message: 'Item tidak ditemukan' };
  
  var ids = sh.getRange(2, 1, lastRow - 1, 1).getValues().map(function(r) { return Number(r[0]); });
  var rowIndex = ids.indexOf(id);
  if (rowIndex === -1) return { success: false, message: 'Item tidak ditemukan' };
  
  sh.deleteRow(rowIndex + 2);
  return { success: true, message: 'Item berhasil dihapus' };
}

// ───────────────────────────────────────────────────────────
//  INCLUDE HELPER — untuk menyertakan file HTML partial
// ───────────────────────────────────────────────────────────
function include(filename) {
  return HtmlService.createHtmlOutputFromFile(filename).getContent();
}
