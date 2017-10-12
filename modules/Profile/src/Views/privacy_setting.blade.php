<div class="alert alert-success hide" id="privSetiSuccMsg"></div>
<div class="alert alert-danger hide" id="privSetiFailMsg"></div>
<form name="frmPrivacySetting" id="frmPrivacySetting" method="post" action="{{ url('user/privacySettings') }}">
                                    <div class="row">
                                        <div class="col-sm-12"><strong>Profile appearing on world map view </strong></div>
                                        <div class="col-sm-12 radio-inputs">
                                            <label class="radio-inline"><input @if('0' === $appear_to_world_map) checked @endif type="radio" value="0" name="profileAppearWorldMap">Yes</label>
                                            <label class="radio-inline"><input @if('1' === $appear_to_world_map) checked @endif type="radio" value="1" name="profileAppearWorldMap">No</label>
                                            <label class="radio-inline"><input @if('2' === $appear_to_world_map) checked @endif type="radio" value="2" name="profileAppearWorldMap">Only to Connections </label>
                                        </div>
                                    </div>
                                    <div class="row margin-T-40">
                                        <div class="col-sm-12"><strong>Profile appearing in search results in My Network </strong></div>
                                        <div class="col-sm-12 radio-inputs">
                                            <label class="radio-inline"><input @if(0 == $appear_to_my_network) checked @endif type="radio" value="0" name="profileAppearMyNetwork">Yes </label>
                                            <label class="radio-inline"><input @if(1 == $appear_to_my_network) checked @endif type="radio" value="1" name="profileAppearMyNetwork">No</label>
                                            <label class="radio-inline"><input @if(2 == $appear_to_my_network) checked @endif type="radio" value="2" name="profileAppearMyNetwork">Only to Connections </label>
                                        </div>
                                    </div>
                                    <div class="row margin-T-40">
                                        <div class="col-sm-12"><strong>View Pedigree Information </strong></div>
                                        <div class="gedcom-privacy">
                                            <div class="col-sm-12">For Gedcom 1</div>
                                            <div class="col-sm-12 radio-inputs">
                                                <label class="checkbox-inline"><input @if(1 == $pedigree['public']) checked @endif type="checkbox" name="pediInfo[ToPublic]"  value="1">Public </label>
                                                <label class="checkbox-inline"><input @if(1 == $pedigree['closeFamily']) checked @endif type="checkbox" name="pediInfo[ToCloseFamily]" value="1">Close Family</label>
                                                <label class="checkbox-inline"><input @if(1 == $pedigree['relative']) checked @endif type="checkbox" name="pediInfo[ToRelative]" value="1">Relative</label>
                                                <label class="checkbox-inline"><input @if(1 == $pedigree['researchConnection']) checked @endif type="checkbox" name="pediInfo[ToResearchConnection]" value="1">Research Connection </label>
                                                <label class="checkbox-inline"><input @if("nobody" === $pedigree['nobody']) checked @endif type="checkbox" name="pediInfo[ToNobody]" value="nobody">Nobody </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row margin-T-40">
                                        <div class="col-sm-12"><strong>Self-Owned Images </strong></div>
                                        <div class="col-sm-12 radio-inputs">
                                            <label class="checkbox-inline"><input @if(1 == $images['public']) checked @endif type="checkbox" name="imageInfo[ToPublic]"  value="1">Public </label>
                                            <label class="checkbox-inline"><input @if(1 == $images['closeFamily']) checked @endif type="checkbox" name="imageInfo[ToCloseFamily]"  value="1">Close Family</label>
                                            <label class="checkbox-inline"><input @if(1 == $images['relative']) checked @endif type="checkbox" name="imageInfo[ToRelative]" value="1">Relative</label>
                                            <label class="checkbox-inline"><input @if(1 == $images['researchConnection']) checked @endif type="checkbox" name="imageInfo[ToResearchConnection]" value="1">Research Connection </label>
                                            <label class="checkbox-inline"><input @if("nobody" === $images['nobody']) checked @endif type="checkbox" name="imageInfo[ToNobody]" value="nobody">Nobody  </label>
                                        </div>
                                    </div>
                                    <div class="row margin-T-40">
                                        <div class="col-sm-12"><strong>Self-Owned Videos  </strong></div>
                                        <div class="col-sm-12 radio-inputs">
                                            <label class="checkbox-inline"><input @if(1 == $videos['public']) checked @endif type="checkbox" name="videoInfo[ToPublic]" value="1">Public </label>
                                            <label class="checkbox-inline"><input @if(1 == $videos['closeFamily']) checked @endif type="checkbox" name="videoInfo[ToCloseFamily]" value="1">Close Family</label>
                                            <label class="checkbox-inline"><input @if(1 == $videos['relative']) checked @endif type="checkbox" name="videoInfo[ToRelative]" value="1">Relative</label>
                                            <label class="checkbox-inline"><input @if(1 == $videos['researchConnection']) checked @endif type="checkbox" name="videoInfo[ToResearchConnection]" value="1">Research Connection </label>
                                            <label class="checkbox-inline"><input @if("nobody" === $videos['nobody']) checked @endif type="checkbox" name="videoInfo[ToNobody]" value="nobody">Nobody  </label>
                                        </div>
                                    </div>
                                    <div class="row margin-T-40">
                                        <div class="col-sm-12"><strong>Self-Owned Journals</strong></div>
                                        <div class="col-sm-12 radio-inputs">
                                            <label class="checkbox-inline"><input @if(1 == $journals['public']) checked @endif type="checkbox" name="journalsInfo[ToPublic]" value="1">Public </label>
                                            <label class="checkbox-inline"><input @if(1 == $journals['closeFamily']) checked @endif type="checkbox" name="journalsInfo[ToCloseFamily]" value="1">Close Family</label>
                                            <label class="checkbox-inline"><input @if(1 == $journals['relative']) checked @endif type="checkbox" name="journalsInfo[ToRelative]" value="1">Relative</label>
                                            <label class="checkbox-inline"><input @if(1 == $journals['researchConnection']) checked @endif type="checkbox" name="journalsInfo[ToResearchConnection]" value="1">Research Connection </label>
                                            <label class="checkbox-inline"><input @if("nobody" === $journals['nobody']) checked @endif type="checkbox" name="journalsInfo[ToNobody]" value="nobody">Nobody  </label>
                                        </div>
                                    </div>
                                    <div class="row margin-T-40">
                                        <div class="col-sm-12"><strong>Self-Owned Events </strong></div>
                                        <div class="col-sm-12 radio-inputs">
                                            <label class="checkbox-inline"><input @if(1 == $event['public']) checked @endif type="checkbox" name="eventsInfo[ToPublic]" value="1">Public </label>
                                            <label class="checkbox-inline"><input @if(1 == $event['closeFamily']) checked @endif type="checkbox" name="eventsInfo[ToCloseFamily]" value="1">Close Family</label>
                                            <label class="checkbox-inline"><input @if(1 == $event['relative']) checked @endif type="checkbox" name="eventsInfo[ToRelative]" value="1">Relative</label>
                                            <label class="checkbox-inline"><input @if(1 == $event['researchConnection']) checked @endif type="checkbox" name="eventsInfo[ToResearchConnection]" value="1">Research Connection </label>
                                            <label class="checkbox-inline"><input @if('nobody' === $event['nobody']) checked @endif type="checkbox" name="eventsInfo[ToNobody]" value="nobody">Nobody  </label>
                                        </div>
                                    </div>
                                    <div class="border-bttm margin-T-20"></div>
                                    <div class="row">
                                        <div class="col-sm-12 margin-T-20">
                                            <button type="submit" class="btn btn-raised btn-green pull-right">Submit</button>
                                            <button type="button" class="btn btn-raised btn-default pull-right margin-R-20">Cancel</button>
                                        </div>
                                    </div>
                                </form>
                                
