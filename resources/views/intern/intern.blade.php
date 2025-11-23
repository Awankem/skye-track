@extends('layout.app')
@section('title', 'Intern')
@section('content')
        <div class="px-40 flex flex-1 justify-center py-5">
          <div class="layout-content-container flex flex-col max-w-[960px] flex-1">
            <div class="flex flex-col justify-between gap-3 p-4">
              <div class="flex min-w-72 flex-col gap-3">
                {{-- Back Button --}}
                <a href="{{ route('intern.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-1 mb-2">
                    <i class="fas fa-arrow-left"></i>
                    Back to Interns
                </a>
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
            @livewire('intern-attendance', ['internId' => $intern->id])
          </div>
        </div>
@endsection