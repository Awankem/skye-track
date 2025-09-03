@extends('layout.app')
@section('title', 'Intern')
@section('content')
        <div class="px-40 flex flex-1 justify-center py-5">
          <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="flex flex-col justify-between gap-3 p-4">
              <div class="flex min-w-72 flex-col gap-3">
                <p class="text-[#111418] tracking-light text-[32px] font-bold leading-tight">Intern Profile</p>
                <p class="text-[#617589] text-sm font-normal leading-normal">View and manage intern attendance records.</p>
              </div>
            </div>
            <div class="flex p-4 @container">
              <div class="flex w-full flex-col gap-4 @[520px]:flex-row @[520px]:justify-between @[520px]:items-center">
                <div class="flex gap-4">
                  <div
                    class="bg-center bg-no-repeat aspect-square bg-cover rounded-full min-h-32 w-32">
                    <img class="rounded-full min-h-3 w-32" src="{{ $intern->profile_url ? $intern->profile_url : 'https://ui-avatars.com/api/?name=' . urlencode($intern->name) . '&background=36517e&color=fff&size=128' }}"
                     class="talent-holder cursor-pointer hover:opacity-90 transition-opacity"
                     @click="open = true" 
                     alt="{{ $intern->name }}"
                     onerror="this.onerror=null; this.src='https://ui-avatars.com/api/?name={{ urlencode($intern->name) }}&background=36517e&color=fff&size=128';">
                  </div>
                  <div class="flex flex-col justify-center">
                    <p class="text-[#111418] text-[22px] font-bold leading-tight tracking-[-0.015em]">{{$intern->name}}</p>
                    <p class="text-[#617589] text-base font-normal leading-normal">{{'Intern' . " " .$intern->department . " " . 'Department'}}</p>
                    <p class="text-[#617589] text-base font-normal leading-normal">Current Day: {{ \Carbon\Carbon::now()->format('F j, Y') }}</p>
                  </div>
                </div>
              </div>
            </div>
            <h2 class="text-[#111418] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Attendance Summary</h2>
            <div class="flex flex-wrap gap-4 p-4">
              <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 border border-[#dde0e4]">
                <p class="text-[#121417] text-base font-medium leading-normal">Total Days</p>
                <p class="text-[#121417] tracking-light text-2xl font-bold leading-tight">{{ totalDays($intern->id) }}</p>
              </div>
              <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 border border-[#dde0e4]">
                <p class="text-[#121417] text-base font-medium leading-normal">Present Days</p>
                <p class="text-[#121417] tracking-light text-2xl font-bold leading-tight">{{ presentDays($intern->id) }}</p>
              </div>
              <div class="flex min-w-[158px] flex-1 flex-col gap-2 rounded-xl p-6 border border-[#dde0e4]">
                <p class="text-[#121417] text-base font-medium leading-normal">Absent Days</p>
                <p class="text-[#121417] tracking-light text-2xl font-bold leading-tight">{{ absentDays($intern->id) }}</p>
              </div>
            </div>
            {{-- <h2 class="text-[#111418] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Attendance Calendar</h2>
            <div class="flex flex-wrap items-center justify-center gap-6 p-4">
              <div class="flex min-w-72 max-w-[336px] flex-1 flex-col gap-0.5">
                <div class="flex items-center p-1 justify-between">
                  <button>
                    <div class="text-[#111418] flex size-10 items-center justify-center" data-icon="CaretLeft" data-size="18px" data-weight="regular">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" fill="currentColor" viewBox="0 0 256 256">
                        <path d="M165.66,202.34a8,8,0,0,1-11.32,11.32l-80-80a8,8,0,0,1,0-11.32l80-80a8,8,0,0,1,11.32,11.32L91.31,128Z"></path>
                      </svg>
                    </div>
                  </button>
                  <p class="text-[#111418] text-base font-bold leading-tight flex-1 text-center pr-10">September 2023</p>
                </div>
                <div class="grid grid-cols-7">
                  <p class="text-[#111418] text-[13px] font-bold leading-normal tracking-[0.015em] flex h-12 w-full items-center justify-center pb-0.5">S</p>
                  <p class="text-[#111418] text-[13px] font-bold leading-normal tracking-[0.015em] flex h-12 w-full items-center justify-center pb-0.5">M</p>
                  <p class="text-[#111418] text-[13px] font-bold leading-normal tracking-[0.015em] flex h-12 w-full items-center justify-center pb-0.5">T</p>
                  <p class="text-[#111418] text-[13px] font-bold leading-normal tracking-[0.015em] flex h-12 w-full items-center justify-center pb-0.5">W</p>
                  <p class="text-[#111418] text-[13px] font-bold leading-normal tracking-[0.015em] flex h-12 w-full items-center justify-center pb-0.5">T</p>
                  <p class="text-[#111418] text-[13px] font-bold leading-normal tracking-[0.015em] flex h-12 w-full items-center justify-center pb-0.5">F</p>
                  <p class="text-[#111418] text-[13px] font-bold leading-normal tracking-[0.015em] flex h-12 w-full items-center justify-center pb-0.5">S</p>
                  <button class="h-12 w-full text-[#111418] col-start-4 text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">1</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">2</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">3</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">4</div>
                  </button>
                  <button class="h-12 w-full text-white text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full bg-[#2789ec]">5</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">6</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">7</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">8</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">9</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">10</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">11</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">12</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">13</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">14</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">15</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">16</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">17</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">18</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">19</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">20</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">21</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">22</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">23</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">24</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">25</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">26</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">27</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">28</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">29</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">30</div>
                  </button>
                </div>
              </div>
              <div class="flex min-w-72 max-w-[336px] flex-1 flex-col gap-0.5">
                <div class="flex items-center p-1 justify-between">
                  <p class="text-[#111418] text-base font-bold leading-tight flex-1 text-center pl-10">October 2023</p>
                  <button>
                    <div class="text-[#111418] flex size-10 items-center justify-center" data-icon="CaretRight" data-size="18px" data-weight="regular">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18px" height="18px" fill="currentColor" viewBox="0 0 256 256">
                        <path d="M181.66,133.66l-80,80a8,8,0,0,1-11.32-11.32L164.69,128,90.34,53.66a8,8,0,0,1,11.32-11.32l80,80A8,8,0,0,1,181.66,133.66Z"></path>
                      </svg>
                    </div>
                  </button>
                </div>
                <div class="grid grid-cols-7">
                  <p class="text-[#111418] text-[13px] font-bold leading-normal tracking-[0.015em] flex h-12 w-full items-center justify-center pb-0.5">S</p>
                  <p class="text-[#111418] text-[13px] font-bold leading-normal tracking-[0.015em] flex h-12 w-full items-center justify-center pb-0.5">M</p>
                  <p class="text-[#111418] text-[13px] font-bold leading-normal tracking-[0.015em] flex h-12 w-full items-center justify-center pb-0.5">T</p>
                  <p class="text-[#111418] text-[13px] font-bold leading-normal tracking-[0.015em] flex h-12 w-full items-center justify-center pb-0.5">W</p>
                  <p class="text-[#111418] text-[13px] font-bold leading-normal tracking-[0.015em] flex h-12 w-full items-center justify-center pb-0.5">T</p>
                  <p class="text-[#111418] text-[13px] font-bold leading-normal tracking-[0.015em] flex h-12 w-full items-center justify-center pb-0.5">F</p>
                  <p class="text-[#111418] text-[13px] font-bold leading-normal tracking-[0.015em] flex h-12 w-full items-center justify-center pb-0.5">S</p>
                  <button class="h-12 w-full text-[#111418] col-start-4 text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">1</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">2</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">3</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">4</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">5</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">6</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">7</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">8</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">9</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">10</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">11</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">12</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">13</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">14</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">15</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">16</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">17</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">18</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">19</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">20</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">21</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">22</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">23</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">24</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">25</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">26</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">27</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">28</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">29</div>
                  </button>
                  <button class="h-12 w-full text-[#111418] text-sm font-medium leading-normal">
                    <div class="flex size-full items-center justify-center rounded-full">30</div>
                  </button>
                </div>
              </div>
            </div> --}}
            <h2 class="text-[#111418] text-[22px] font-bold leading-tight tracking-[-0.015em] px-4 pb-3 pt-5">Attendance Log</h2>
            <div class="flex justify-between gap-2 px-4 py-3">
              {{-- <div class="flex gap-2">
                <button class="p-2 text-[#111418]">
                  <div class="text-[#111418]" data-icon="SortAscending" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M128,128a8,8,0,0,1-8,8H48a8,8,0,0,1,0-16h72A8,8,0,0,1,128,128ZM48,72H184a8,8,0,0,0,0-16H48a8,8,0,0,0,0,16Zm56,112H48a8,8,0,0,0,0,16h56a8,8,0,0,0,0-16Zm125.66-21.66a8,8,0,0,0-11.32,0L192,188.69V112a8,8,0,0,0-16,0v76.69l-26.34-26.35a8,8,0,0,0-11.32,11.32l40,40a8,8,0,0,0,11.32,0l40-40A8,8,0,0,0,229.66,162.34Z"
                      ></path>
                    </svg>
                  </div>
                </button>
                <button class="p-2 text-[#111418]">
                  <div class="text-[#111418]" data-icon="Sliders" data-size="24px" data-weight="regular">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" fill="currentColor" viewBox="0 0 256 256">
                      <path
                        d="M64,105V40a8,8,0,0,0-16,0v65a32,32,0,0,0,0,62v49a8,8,0,0,0,16,0V167a32,32,0,0,0,0-62Zm-8,47a16,16,0,1,1,16-16A16,16,0,0,1,56,152Zm80-95V40a8,8,0,0,0-16,0V57a32,32,0,0,0,0,62v97a8,8,0,0,0,16,0V119a32,32,0,0,0,0-62Zm-8,47a16,16,0,1,1,16-16A16,16,0,0,1,128,104Zm104,64a32.06,32.06,0,0,0-24-31V40a8,8,0,0,0-16,0v97a32,32,0,0,0,0,62v17a8,8,0,0,0,16,0V199A32.06,32.06,0,0,0,232,168Zm-32,16a16,16,0,1,1,16-16A16,16,0,0,1,200,184Z"
                      ></path>
                    </svg>
                  </div>
                </button>
              </div> --}}
            </div>
            <div class="px-4 py-3 flex flex-row justify-between gap-3 items-center">
              <div class="flex flex-row gap-2">
                <form method="GET" action="{{ route('intern.show', $intern->id) }}" class="flex items-center gap-2">
                  <input 
                      type="date" 
                      name="date" 
                      value="{{ request('date') }}" 
                      class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500"
                  >
                  <button 
                      type="submit" 
                      class="bg-blue-600 text-white px-4 py-2 rounded-md text-sm font-medium hover:bg-blue-700">
                      Filter
                  </button>
              </form>

               @if(request('date'))
                  <a href="{{ route('intern.show', $intern->id) }}" 
                    class="text-red-500 text-sm pt-4">Clear Filter</a>
              @endif
              </div>
              <a href="{{ route('intern.attendance.export', $intern->id) }}"
                class="flex max-w-[480px] cursor-pointer items-center justify-center overflow-hidden rounded-full h-10 bg-[#2789ec] text-white gap-2 text-sm font-bold leading-normal tracking-[0.015em] min-w-0 px-4"
              >
                <div class="text-white" data-icon="DownloadSimple" data-size="20px" data-weight="fill">
                  <svg xmlns="http://www.w3.org/2000/svg" width="20px" height="20px" fill="currentColor" viewBox="0 0 256 256">
                    <path
                      d="M82.34,117.66A8,8,0,0,1,88,104h32V40a8,8,0,0,1,16,0v64h32a8,8,0,0,1,5.66,13.66l-40,40a8,8,0,0,1-11.32,0ZM216,144a8,8,0,0,0-8,8v56H48V152a8,8,0,0,0-16,0v56a16,16,0,0,0,16,16H208a16,16,0,0,0,16-16V152A8,8,0,0,0,216,144Z"
                    ></path>
                  </svg>
                </div>
                <span class="truncate">Export</span>
              </a>
            </div>

            <div class="px-4 py-3 @container">
              <div class="flex overflow-hidden rounded-xl border border-[#dbe0e6] bg-white">
                <table class="flex-1">
                  <thead>
                    <tr class="bg-white">
                      <th class="date px-4 py-3 text-left text-[#111418] w-[400px] text-xl font-bold leading-normal bg-gradient-to-r from-gray-200 to-gray-400">Date</th>
                      <th class="status px-4 py-3 text-left text-[#111418] w-[400px] text-xl font-bold leading-normal bg-gradient-to-r from-gray-300 to-gray-200">Status</th>

                      <th class="time-in px-4 py-3 text-left text-[#111418] w-[400px] text-xl font-bold leading-normal bg-gradient-to-r from-gray-100 to-gray-300">Time In</th>
                      <th class="time-out px-4 py-3 text-left text-[#111418] w-[400px] text-xl font-bold leading-normal bg-gradient-to-r from-gray-200 to-gray-400">
                        Time Out
                      </th>
                      <th class="duration px-4 py-3 text-left text-[#111418] w-[400px] text-xl font-bold leading-normal bg-gradient-to-r from-gray-100 to-gray-300">
                        Duration<span>/Hours</span>
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @forelse ($internAttendance as $attendance)     
                    <tr class="border-t border-t-[#dbe0e6]">
                      <td class="date h-[72px] px-4 py-2 w-[400px] text-[#617589] text-md font-medium leading-normal">
                        {{-- {{ ($attendance->date)->format('m-d-Y') }} --}}
                        {{ ($attendance->date)->format('l, j F Y') }}
                      </td>
                      <td class="status h-[72px] px-4 py-2 w-[400px] text-[#617589] text-sm font-normal leading-normal">{{ $attendance->status }}</td>
                      <td class="time-in h-[72px] px-4 py-2 w-[400px] text-[#617589] text-sm font-normal leading-normal">{{ substr($attendance->sign_in, 11) }}</td>
                      <td class="time-out h-[72px] px-4 py-2 w-[400px] text-[#617589] text-sm font-normal leading-normal">{{ substr($attendance->sign_out, 11) }}</td>
                      <td class="duration h-[72px] px-4 py-2 w-[400px] text-[#617589] text-sm font-normal leading-normal">{{ calculateDuration($attendance->sign_out, $attendance->sign_in) }}</td>
                    </tr>
                    @empty
                    <tr>
                      <td colspan="5" class="text-center py-4 text-gray-500">No attendance records found for this date.</td>
                    </tr>
                    @endforelse
                  </tbody>
                </table>
              </div>
              <style>
                @container(max-width:120px){.table-8c03f1c7-002b-4d4f-8e93-6347bc2c2b98-column-100{display: none;}}
                @container(max-width:120px){.status{display: none;}}
                @container(max-width:240px){.time-in{display: none;}}
                @container(max-width:360px){.time-out{display: none;}}
                @container(max-width:480px){.duration{display: none;}}
              </style>
            </div>
            {{-- Pagination --}}
          @if($internAttendance->hasPages())
              <div class="px-4 py-3">
                  <div class="flex items-center justify-between">
                      <div class="text-sm text-gray-700">
                          Showing {{ $internAttendance->firstItem() ?? 0 }} to {{ $internAttendance->lastItem() ?? 0 }} of {{ $internAttendance->total() }} results
                      </div>
                      <div class="flex space-x-2">
                          {{-- Previous Button --}}
                          @if ($internAttendance->onFirstPage())
                              <span class="px-3 py-2 text-sm text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">
                                  Previous
                              </span>
                          @else
                              <a href="{{ $internAttendance->previousPageUrl() }}" class="px-3 py-2 text-sm text-white bg-[#3971c5] rounded-md hover:bg-blue-600 transition">
                                  Previous
                              </a>
                          @endif

                          {{-- Page Numbers --}}
                          @foreach ($internAttendance->getUrlRange(1, $internAttendance->lastPage()) as $page => $url)
                              @if ($page == $internAttendance->currentPage())
                                  <span class="px-3 py-2 text-sm text-white bg-[#3971c5] rounded-md">
                                      {{ $page }}
                                  </span>
                              @else
                                  <a href="{{ $url }}" class="px-3 py-2 text-sm text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 transition">
                                      {{ $page }}
                                  </a>
                              @endif
                          @endforeach

                          {{-- Next Button --}}
                          @if ($internAttendance->hasMorePages())
                              <a href="{{ $internAttendance->nextPageUrl() }}" class="px-3 py-2 text-sm text-white bg-[#3971c5] rounded-md hover:bg-blue-600 transition">
                                  Next
                              </a>
                          @else
                              <span class="px-3 py-2 text-sm text-gray-400 bg-gray-200 rounded-md cursor-not-allowed">
                                  Next
                              </span>
                          @endif
                      </div>
                  </div>
              </div>
          @endif
          </div>
        </div>
@endsection